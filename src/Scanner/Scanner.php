<?php

namespace BrushCSS\Scanner;

use Symfony\Component\Finder\Finder;

class Scanner
{
    public function scan(array $paths): array
    {
        $finder = new Finder();
        $finder->files()->in($paths);

        $classes = [];

        foreach ($finder as $file) {
            preg_match_all('/class="([^"]+)"/', $file->getContents(), $matches);

            foreach ($matches[1] as $group) {
                foreach (preg_split('/\s+/', $group) as $cls) {
                    $classes[] = trim($cls);
                }
            }
        }

        return array_unique($classes);
    }
}
