<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Flag;

class FlagTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $argument = new Flag('test', 'value');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Flag', $argument);
    }

    public function testToString()
    {
        $argument = new Flag('test', 'value');
        $this->assertEquals("-test 'value'", (string) $argument, 'Flag should cast to a string');
    }

    public function testEscapesArgValue()
    {
        $argument = new Flag('test', '&&');
        $this->assertEquals("-test '&&'", (string) $argument, 'Flag should be escaped');
    }

    public function testGetName()
    {
        $argument = new Flag('test', '&&');
        $this->assertEquals('test', $argument->getName(), 'Flag name should be returned');
    }

    public function testEmptyFlag()
    {
        $argument = new Flag('test');
        $this->assertEquals('-test', (string) $argument, 'Valueless arguments should be allowed');
    }
}
