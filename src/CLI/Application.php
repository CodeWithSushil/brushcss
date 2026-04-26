<?php

namespace BrushCSS\CLI;

use BrushCSS\CLI\Commands\AddCommand;

final class Application
{
    public function run(array $argv): void
    {
        $cmd = $argv[1] ?? null;

        match ($cmd) {

            'add' => (new AddCommand())
                ->handle($argv[2] ?? ''),

            'build' => $this->build(),

            default => $this->help()
        };
    }

    private function builds(): void
    {
         echo "🔍 Scanning files...\n";

    $paths = ['examples']; // change to 'views' in real app

    $extractor = new \BrushCSS\JIT\ClassExtractor();
    $resolver  = new \BrushCSS\JIT\Resolver();
    $engine    = new \BrushCSS\JIT\JITEngine($resolver);

    $classes = [];

    foreach ($paths as $path) {
        foreach (glob($path . '/*.php') as $file) {
            $content = file_get_contents($file);

            $found = $extractor->extract($content);

            echo "📄 {$file} → " . implode(', ', $found) . "\n";

            $classes = array_merge($classes, $found);
        }
    }

    $classes = array_unique($classes);

    echo "⚙️ Generating CSS...\n";

    $css = $engine->build($classes);

    if (!is_dir('public')) {
        mkdir('public', 777, true);
    }

    file_put_contents('public/style.css', $css);

    echo "✅ CSS written to public/style.css\n";
        echo "Building CSS...\n";
    }

    private function help(): void
    {
        echo "brushcss add <plugin>\nbrushcss build\n";
    }

    private function build(): void
{
    echo "🚀 Build started\n";

    $paths = ['examples'];

    $extractor = new \BrushCSS\JIT\ClassExtractor();
    $resolver  = new \BrushCSS\JIT\Resolver();
    $engine    = new \BrushCSS\JIT\JITEngine($resolver);

    $classes = [];

    foreach ($paths as $path) {

        echo "📂 Scanning: {$path}\n";

        $files = glob($path . '/*.php');

        if (!$files) {
            echo "❌ No files found in {$path}\n";
        }

        foreach ($files as $file) {

            echo "📄 Reading: {$file}\n";

            $content = file_get_contents($file);

            if (!$content) {
                echo "❌ Empty file: {$file}\n";
            }

            $found = $extractor->extract($content);

            echo "🎯 Classes: " . json_encode($found) . "\n";

            $classes = array_merge($classes, $found);
        }
    }

    $classes = array_unique($classes);

    echo "📦 Final classes: " . json_encode($classes) . "\n";

    $css = $engine->build($classes);

    echo "🧾 Generated CSS:\n$css\n";

    if (!is_dir('public')) {
        echo "📁 Creating public directory...\n";
        mkdir('public', 0777, true);
    }

    $result = file_put_contents('public/style.css', $css);

    if ($result === false) {
        echo "❌ Failed to write CSS file\n";
    } else {
        echo "✅ CSS written to public/style.css\n";
    }
}
}
