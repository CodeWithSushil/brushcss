<?php

namespace BrushCSS\Writer;

class Writer
{
    public function write(string $path, string $css)
    {
        $full = getcwd() . '/' . $path;

        if (!is_dir(dirname($full))) {
            mkdir(dirname($full), 0777, true);
        }

        file_put_contents($full, $css);
    }
}
