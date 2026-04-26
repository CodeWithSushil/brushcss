<?php

declare(strict_types=1);

namespace BrushCSS\AST;

interface Node
{
    public function toCss(): string;
}
