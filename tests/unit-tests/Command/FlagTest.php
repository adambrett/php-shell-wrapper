<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Flag;
use PHPUnit\Framework\TestCase;

class FlagTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $argument = new Flag('test', 'value');
        $this->assertInstanceOf(Flag::class, $argument);
    }

    public function testToString()
    {
        $argument = new Flag('test', 'value');
        $this->assertEquals("-test 'value'", (string)$argument, 'Flag should cast to a string');
    }

    public function testEscapesArgValue()
    {
        $argument = new Flag('test', '&&');
        $this->assertEquals("-test '&&'", (string)$argument, 'Flag should be escaped');
    }

    public function testGetName()
    {
        $argument = new Flag('test', '&&');
        $this->assertEquals('test', $argument->getName(), 'Flag name should be returned');
    }

    public function testEmptyFlag()
    {
        $argument = new Flag('test');
        $this->assertEquals('-test', (string)$argument, 'Valueless arguments should be allowed');
    }

    public function testMultipleOfSameName()
    {
        $param = new Flag('test', array('value1', 'value2'));
        $this->assertEquals("-test 'value1' -test 'value2'", (string)$param, 'Mutiple flags should be allowed');
    }
}
