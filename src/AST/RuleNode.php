<?php

namespace BrushCSS\AST;

class RuleNode implements Node
{
    public function __construct(
        public string $selector,
        public array $rules
    ) {}

    public function toCss(): string
    {
        $body = '';
        foreach ($this->rules as $k => $v) {
            $body .= "$k:$v;";
        }
        return "{$this->selector}{{$body}}";
    }
}
