<?php
namespace BrushCSS\AST;

class VariantNode implements Node
{
    public function __construct(
        public string $variant,
        public Node $child,
        public array $config
    ) {}

    public function toCss(): string
    {
        return match ($this->variant) {
            'hover' => $this->pseudo(':hover'),
            'focus' => $this->pseudo(':focus'),
            'md' => "@media (min-width: {$this->config['theme']['breakpoints']['md']}){" . $this->child->toCss() . "}",
            default => $this->child->toCss()
        };
    }

    private function pseudo(string $pseudo): string
    {
        if ($this->child instanceof RuleNode) {
            return (new RuleNode(
                $this->child->selector . $pseudo,
                $this->child->rules
            ))->toCss();
        }
        return $this->child->toCss();
    }
}
