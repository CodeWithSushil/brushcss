<?php

namespace Brush\Css;

class Files
{
    public static function createFile()
    {
        $file = [];
        if (! file_exists('brush.min.css')) {
            touch('brush.min.css');
        }
        self::readFiles();
    }

    public static function readFiles()
    {
        fopen('brush.min.css', 'r+');
    }
}

Files::createFile();
