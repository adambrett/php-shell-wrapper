<?php

namespace AdamBrett\ShellWrapper\Tests\Command\Collections;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Command\Collections\Command as Commands;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $commandsArray = array();
        $commands = new Commands($commandsArray);
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Collections\Command', $commands);
    }

    public function testToStringAnd()
    {
        $commands = new Commands([new Command('cd'), new Command('ls')]);
        $this->assertEquals('cd && ls', (string) $commands, 'Commands should be joined by and');
    }

    public function testToStringOr()
    {
        $commands = new Commands([new Command('cd'), new Command('ls')], Commands::C_OR);
        $this->assertEquals('cd || ls', (string) $commands, 'Commands should be joined by or');
    }

    public function testChainedCommands()
    {
        $and = new Commands([new Command('cd'), new Command('ls')]);
        $or = new Commands([$and, new Command('ls')], Commands::C_OR);
        $this->assertEquals('cd && ls || ls', (string) $or, 'Commands should be joined by and and or');
    }

    public function testCommandsRequireCommandInterface()
    {
        $this->setExpectedException('InvalidArgumentException');
        $commands = new Commands(['ls']);
    }
}
