<?php

namespace BrushCSS\Plugin;

use BrushCSS\Core\BrushContext;
use BrushCSS\Plugin\Contracts\BrushPlugin;

final class PluginLoader
{
    public function load(array $plugins, BrushContext $context): void
    {
        foreach ($plugins as $plugin) {
            if (class_exists($plugin)) {
                $instance = new $plugin();

                if ($instance instanceof BrushPlugin) {
                    $instance->register($context);
                }
            }
        }
    }
}
