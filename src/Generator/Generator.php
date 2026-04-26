<?php

namespace BrushCSS\Generator;

class Generator
{
    public function generate(array $nodes): string
    {
        return implode("\n", array_map(fn($n) => $n->toCss(), $nodes));
    }
}
