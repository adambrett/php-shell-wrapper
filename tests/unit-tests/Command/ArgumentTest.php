<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Argument;

class ArgumentTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $argument = new Argument('test', 'value');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Argument', $argument);
    }

    public function testToString()
    {
        $argument = new Argument('test', 'value');
        $this->assertEquals("--test 'value'", (string) $argument, 'Argument should cast to a string');
    }

    public function testEscapesArgValue()
    {
        $argument = new Argument('test', '&&');
        $this->assertEquals("--test '&&'", (string) $argument, 'Argument should be escaped');
    }

    public function testGetName()
    {
        $argument = new Argument('test', '&&');
        $this->assertEquals('test', $argument->getName(), 'Argument name should be returned');
    }

    public function testEmptyArgument()
    {
        $argument = new Argument('test');
        $this->assertEquals('--test', (string) $argument, 'Valueless arguments should be allowed');
    }

    public function testMultipleOfSameName()
    {
        $param = new Argument('test', array('value1', 'value2'));
        $this->assertEquals("--test 'value1' --test 'value2'", (string) $param, 'Mutiple params should be allowed');
    }
}
