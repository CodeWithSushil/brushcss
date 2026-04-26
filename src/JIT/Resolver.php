<?php

namespace BrushCSS\JIT;

use BrushCSS\Core\CSSRule;

final class Resolver
{
    public function resolve(string $class): ?CssRule
    {
        return match (true) {

            str_starts_with($class, 'p-') =>
                new CssRule(".{$class}", ['padding' => '16px']),

            str_starts_with($class, 'mt-') =>
                new CssRule(".{$class}", ['margin-top' => '20px']),

            str_starts_with($class, 'bg-') =>
                new CssRule(".{$class}", ['background' => '#3b82f6']),

            default => null
        };
    }
}
