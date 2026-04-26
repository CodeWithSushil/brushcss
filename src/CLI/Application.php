<?php

namespace BrushCSS\CLI;

use Symfony\Component\Console\Application as SymfonyApplication;
use BrushCSS\CLI\Commands\BuildCommand;
use BrushCSS\Config\ConfigLoader;

final class Application extends SymfonyApplication
{
    private array $config = [];

    public function __construct()
    {
        parent::__construct('BrushCSS', '1.0.0');
    }

    // -----------------------------
    // BOOTSTRAP SYSTEM
    // -----------------------------
    public function boot(): void
    {
        $this->loadConfig();
        $this->registerCommands();
    }

    // -----------------------------
    // CONFIG LOADING
    // -----------------------------
    private function loadConfig(): void
    {
        $this->config = ConfigLoader::load();
    }

    public function config(): array
    {
        return $this->config;
    }

    // -----------------------------
    // COMMAND REGISTRATION
    // -----------------------------
    private function registerCommands(): void
    {
        $this->addCommand(new BuildCommand());
    }
}
