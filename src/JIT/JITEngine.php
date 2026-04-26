<?php

namespace BrushCSS\JIT;

use BrushCSS\Core\CSSRule;

final class JITEngine
{
    public function __construct(
        private Resolver $resolver
    ) {}

    public function build(array $classes): string
    {
        $css = [];

        foreach ($classes as $class) {
            $rule = $this->resolver->resolve($class);

            if ($rule) {
                $css[] = $rule->toCss();
            }
        }

        return implode("\n", $css);
    }
}
