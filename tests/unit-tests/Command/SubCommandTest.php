<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\SubCommand;

class SubCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $command = new SubCommand('ls');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\SubCommand', $command);
    }

    public function testToString()
    {
        $command = new SubCommand('ls');
        $this->assertEquals('ls', (string) $command, 'SubCommand should cast to a string');
    }
}
