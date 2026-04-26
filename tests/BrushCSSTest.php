<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TestCase::class)]
class BrushCSSTest extends TestCase
{
    #[Test]
    public function test_two_number()
    {
        $this->assertSame(1, 1);
    }
}
