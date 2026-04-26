<?php

namespace BrushCSS\Config;

final class ConfigLoader
{
    private static ?array $cache = null;

    /**
     * Load configuration (with caching)
     */
    public static function load(?string $path = null, bool $fresh = false): array
    {
        if (self::$cache !== null && !$fresh) {
            return self::$cache;
        }

        $path ??= self::detectConfigPath();

        $user = self::loadFile($path);
        $config = self::merge(self::defaults(), $user);

        $config = self::normalize($config);
        self::validate($config);

        return self::$cache = $config;
    }

    // -----------------------------------------
    // 1. Detect config file path
    // -----------------------------------------
    private static function detectConfigPath(): string
    {
        // priority order
        $candidates = [
            getcwd() . '/brush.config.php',
            getcwd() . '/brushcss.config.php',
        ];

        foreach ($candidates as $file) {
            if (is_file($file)) {
                return $file;
            }
        }

        // fallback (no config present)
        return '';
    }

    // -----------------------------------------
    // 2. Load PHP config file safely
    // -----------------------------------------
    private static function loadFile(string $path): array
    {
        if (!$path || !is_file($path)) {
            return [];
        }

        $config = require $path;

        if (!is_array($config)) {
            throw new \RuntimeException("Config file must return array: {$path}");
        }

        return $config;
    }

    // -----------------------------------------
    // 3. Defaults (baseline system)
    // -----------------------------------------
    private static function defaults(): array
    {
        return [
            'input'  => 'resources/css/main.css',
            'output' => 'public/style.css',

            'scan' => ['resources/views'],

            'minify' => true,

            'theme' => [
                'spacing' => [
                    '1' => '0.25rem',
                    '2' => '0.5rem',
                    '3' => '1rem',
                    '4' => '1.5rem',
                    '5' => '2rem',
                ],
                'colors' => [],
                'breakpoints' => [
                    'sm' => '640px',
                    'md' => '768px',
                    'lg' => '1024px',
                ],
            ],

            'plugins' => [],
        ];
    }

    // -----------------------------------------
    // 4. Deep merge (recursive)
    // -----------------------------------------
    private static function merge(array $base, array $user): array
    {
        foreach ($user as $key => $value) {
            if (is_array($value) && isset($base[$key]) && is_array($base[$key])) {
                $base[$key] = self::merge($base[$key], $value);
            } else {
                $base[$key] = $value;
            }
        }

        return $base;
    }

    // -----------------------------------------
    // 5. Normalize paths + structure
    // -----------------------------------------
    private static function normalize(array $config): array
    {
        $cwd = getcwd();

        // normalize input/output
        $config['input']  = self::absPath($config['input'], $cwd);
        $config['output'] = self::absPath($config['output'], $cwd);

        // normalize scan paths
        $config['scan'] = array_map(
            fn($p) => self::absPath($p, $cwd),
            (array) $config['scan']
        );

        return $config;
    }

    private static function absPath(string $path, string $cwd): string
    {
        if (str_starts_with($path, '/') || preg_match('/^[A-Z]:/i', $path)) {
            return $path; // already absolute
        }

        return rtrim($cwd, '/') . '/' . ltrim($path, '/');
    }

    // -----------------------------------------
    // 6. Validation (fail fast)
    // -----------------------------------------
    private static function validate(array $config): void
    {
        if (!is_string($config['input'])) {
            throw new \InvalidArgumentException("Config 'input' must be string");
        }

        if (!is_string($config['output'])) {
            throw new \InvalidArgumentException("Config 'output' must be string");
        }

        if (!is_array($config['scan'])) {
            throw new \InvalidArgumentException("Config 'scan' must be array");
        }

        if (!isset($config['theme']['spacing'])) {
            throw new \InvalidArgumentException("theme.spacing missing");
        }

        if (!is_array($config['theme']['spacing'])) {
            throw new \InvalidArgumentException("theme.spacing must be array");
        }
    }

    // -----------------------------------------
    // 7. Reload (for watch mode)
    // -----------------------------------------
    public static function reload(?string $path = null): array
    {
        self::$cache = null;
        return self::load($path, true);
    }
}
