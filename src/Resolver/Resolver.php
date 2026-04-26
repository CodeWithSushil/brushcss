<?php

namespace BrushCSS\Resolver;

use BrushCSS\AST\RuleNode;
use BrushCSS\AST\VariantNode;

class Resolver
{
    private const MAP = [
        'p' => ['padding'],
        'px' => ['padding-left','padding-right'],
        'py' => ['padding-top','padding-bottom'],
        'm' => ['margin'],
    ];

    public function resolve(string $class, array $config)
    {
        [$variants, $base] = $this->parseVariant($class);

        $node = $this->base($base, $config);

        if (!$node) return null;

        foreach (array_reverse($variants) as $v) {
            $node = new VariantNode($v, $node, $config);
        }

        return $node;
    }

    private function parseVariant(string $class): array
    {
        $parts = explode(':', $class);
        $base = array_pop($parts);
        return [$parts, $base];
    }

    private function base(string $class, array $config)
    {
        if (preg_match('/(p|px|py)-(.+)/', $class, $m)) {
            $prefix = $m[1];
            $key = $m[2];

            $value = $this->value($key, $config);

            if (!$value) return null;

            $rules = [];
            foreach (self::MAP[$prefix] as $prop) {
                $rules[$prop] = $value;
            }

            return new RuleNode($this->escape($class), $rules);
        }

        if (preg_match('/bg-(\w+)-(\d+)/', $class, $m)) {
            $val = $config['theme']['colors'][$m[1]][$m[2]] ?? null;

            if (!$val) return null;

            return new RuleNode($this->escape($class), [
                'background-color' => $val
            ]);
        }

        return null;
    }

    private function value(string $key, array $config)
    {
        if (str_starts_with($key, '[')) {
            return trim($key, '[]');
        }

        return $config['theme']['spacing'][$key] ?? null;
    }

    private function escape(string $class)
    {
        return '.' . preg_replace('/([^a-zA-Z0-9_-])/', '\\\\$1', $class);
    }
}
