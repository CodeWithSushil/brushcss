<?php

namespace BrushCSS\Core;

final class CSSRule
{
    public function __construct(
        public string $selector,
        public array $declarations
    ) {}

    public function toCss(): string
    {
        $out = "";

        foreach ($this->declarations as $k => $v) {
            $out .= "{$k}: {$v};";
        }

        return "{$this->selector} {{$out}}";
    }
}
