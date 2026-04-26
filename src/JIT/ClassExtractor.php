<?php

namespace BrushCSS\JIT;

final class ClassExtractor
{
    public function extract(string $content): array
    {
        preg_match_all('/class=["\']([^"\']+)["\']/', $content, $m);

        $classes = [];

        foreach ($m[1] as $group) {
            $classes = array_merge($classes, explode(' ', trim($group)));
        }

        return array_unique(array_filter($classes));
    }
}
