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
        $commandsArray = array(new Command('cd'), new Command('ls'));
        $commands = new Commands($commandsArray);
        $this->assertEquals('cd && ls', (string) $commands, 'Commands should be joined by and');
    }

    public function testToStringOr()
    {
        $commandsArray = array(new Command('cd'), new Command('ls'));
        $commands = new Commands($commandsArray, Commands::C_OR);
        $this->assertEquals('cd || ls', (string) $commands, 'Commands should be joined by or');
    }

    public function testChainedCommands()
    {
        $andCommandsArray = array(new Command('cd'), new Command('ls'));
        $and = new Commands($andCommandsArray);
        $orCommandsArray = array($and, new Command('ls'));
        $or = new Commands($orCommandsArray, Commands::C_OR);
        $this->assertEquals('cd && ls || ls', (string) $or, 'Commands should be joined by and and or');
    }

    public function testCommandsRequireCommandInterface()
    {
        $this->setExpectedException('InvalidArgumentException');
        $commandsArray = array('ls');
        $commands = new Commands($commandsArray);
    }
}
