<?php

namespace BrushCSS\CLI\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use BrushCSS\Engine\JITEngine;

class BuildCommand extends Command
{
    protected static $defaultName = 'build';
    protected static $defaultDescription = 'Build CSS using BrushCSS JIT engine';

    protected function configure(): void
    {
        $this
            ->addOption(
                'input',
                'i',
                InputOption::VALUE_REQUIRED,
                'Input CSS file',
                'resources/css/main.css'
            )
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Output CSS file',
                'public/style.css'
            )
            ->addOption(
                'scan',
                's',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Scan paths (HTML/PHP)',
                ['resources/views']
            )
            ->addOption(
                'watch',
                'w',
                InputOption::VALUE_NONE,
                'Watch files and rebuild automatically'
            )
            ->addOption(
                'minify',
                'm',
                InputOption::VALUE_NONE,
                'Minify output CSS'
            )
            ->addOption(
                'debug',
                'd',
                InputOption::VALUE_NONE,
                'Enable debug output'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = [
            'input'   => $input->getOption('input'),
            'output'  => $input->getOption('output'),
            'scan'    => $input->getOption('scan'),
            'watch'   => $input->getOption('watch'),
            'minify'  => $input->getOption('minify'),
            'debug'   => $input->getOption('debug'),
        ];

        $engine = new JITEngine();

        try {
            if ($config['watch']) {
                $this->watch($engine, $config, $output);
            } else {
                $this->buildOnce($engine, $config, $output);
            }

            return Command::SUCCESS;

        } catch (\Throwable $e) {
            $output->writeln('<error>[BrushCSS Error]</error> ' . $e->getMessage());

            if ($config['debug']) {
                $output->writeln($e->getTraceAsString());
            }

            return Command::FAILURE;
        }
    }

    // -----------------------------
    // SINGLE BUILD
    // -----------------------------
    private function buildOnce(JITEngine $engine, array $config, OutputInterface $output): void
    {
        $start = microtime(true);

        $engine->run($config);

        $time = number_format((microtime(true) - $start) * 1000, 2);

        $output->writeln("<info>✔ Build completed in {$time} ms</info>");
        $output->writeln("<comment>Output:</comment> {$config['output']}");
    }

    // -----------------------------
    // WATCH MODE (JIT LOOP)
    // -----------------------------
    private function watch(JITEngine $engine, array $config, OutputInterface $output): void
    {
        $output->writeln('<info>👀 Watching for changes...</info>');

        $lastHash = null;

        while (true) {
            clearstatcache();

            $hash = $this->computeHash($config);

            if ($hash !== $lastHash) {
                $output->writeln('<comment>↻ Rebuilding...</comment>');

                $this->buildOnce($engine, $config, $output);

                $lastHash = $hash;
            }

            usleep(300000); // 300ms
        }
    }

    // -----------------------------
    // HASH SYSTEM (JIT TRIGGER)
    // -----------------------------
    private function computeHash(array $config): string
    {
        $data = '';

        // input CSS
        if (file_exists($config['input'])) {
            $data .= file_get_contents($config['input']);
        }

        // scanned files
        foreach ($config['scan'] as $path) {
            if (!is_dir($path)) continue;

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path)
            );

            foreach ($iterator as $file) {
                if (!$file->isFile()) continue;

                $ext = pathinfo($file, PATHINFO_EXTENSION);

                if (!in_array($ext, ['php', 'html'])) continue;

                $data .= file_get_contents($file->getPathname());
            }
        }

        return md5($data);
    }
}
