<?php

namespace BrushCSS\CLI\Commands;

final class AddCommand
{
    public function handle(string $plugin): void
    {
        $package = "brushcss/plugin-{$plugin}";

        passthru("composer require {$package}");
    }
}
