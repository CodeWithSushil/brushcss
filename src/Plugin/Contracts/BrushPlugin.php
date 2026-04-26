<?php

namespace BrushCSS\Plugin\Contracts;

use BrushCSS\Core\BrushContext;

interface BrushPlugin
{
    public function register(BrushContext $context): void;
}
