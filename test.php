<?php

require 'vendor/autoload.php';

use BrushCSS\JIT\ClassExtractor;
use BrushCSS\JIT\Resolver;
use BrushCSS\JIT\JITEngine;

$extractor = new ClassExtractor();
$resolver = new Resolver();
$engine = new JITEngine($resolver);

$classes = $extractor->extract('<div class="p-4 bg-blue-500"></div>');

echo $engine->build($classes);
