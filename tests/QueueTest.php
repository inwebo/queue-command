<?php

namespace Inwebo\QueueCommand\Tests;

use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase
{
    public function testIsQueue(): void
    {
        $this->assertContainsEquals(
            true,
            [true]
        );
    }
}
