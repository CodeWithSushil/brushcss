<?php

namespace BrushCSS\Engine;

use BrushCSS\Config\ConfigLoader;
use BrushCSS\Scanner\Scanner;
use BrushCSS\Resolver\Resolver;
use BrushCSS\Generator\Generator;
use BrushCSS\Writer\Writer;

class JITEngine
{
    public function run(array $cli)
    {
        $config = ConfigLoader::load();

        $scanner = new Scanner();
        $resolver = new Resolver();
        $generator = new Generator();
        $writer = new Writer();

        $classes = $scanner->scan($config['scan']);

        $nodes = [];

        foreach ($classes as $c) {
            $n = $resolver->resolve($c, $config);
            if ($n) $nodes[] = $n;
        }

        $css = $generator->generate($nodes);

        $writer->write($config['output'], $css);
    }
}
