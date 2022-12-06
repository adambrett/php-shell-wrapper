<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Argument;
use PHPUnit\Framework\TestCase;

class ArgumentTest extends TestCase
{
    public function testCanCreateInstance(): void
    {
        $argument = new Argument('test', 'value');
        $this->assertInstanceOf(Argument::class, $argument);
    }

    public function testToString(): void
    {
        $argument = new Argument('test', 'value');
        $this->assertEquals("--test 'value'", (string)$argument, 'Argument should cast to a string');
    }

    public function testEscapesArgValue(): void
    {
        $argument = new Argument('test', '&&');
        $this->assertEquals("--test '&&'", (string)$argument, 'Argument should be escaped');
    }

    public function testGetName(): void
    {
        $argument = new Argument('test', '&&');
        $this->assertEquals('test', $argument->getName(), 'Argument name should be returned');
    }

    public function testEmptyArgument(): void
    {
        $argument = new Argument('test');
        $this->assertEquals('--test', (string)$argument, 'Valueless arguments should be allowed');
    }

    public function testMultipleOfSameName(): void
    {
        $param = new Argument('test', ['value1', 'value2']);
        $this->assertEquals("--test 'value1' --test 'value2'", (string)$param, 'Mutiple arguments should be allowed');
    }
}
