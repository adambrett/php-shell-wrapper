<?php

namespace AdamBrett\ShellWrapper\Tests;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Command\AbstractCommand;
use AdamBrett\ShellWrapper\Command\Argument;
use AdamBrett\ShellWrapper\Command\Flag;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Command\SubCommand;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $command = new Command('ls');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\AbstractCommand', $command);
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command', $command);
    }

    public function testToString()
    {
        $command = new Command('ls');
        $this->assertEquals('ls', (string) $command, 'Command should cast to a string');
    }

    public function testCanHaveSubCommand()
    {
        $command = new Command('ls');
        $command->addSubCommand(new SubCommand('ls'));
        $this->assertEquals('ls ls', (string) $command, 'Command should have sub command');
    }

    public function testCanAddArgument()
    {
        $command = new Command('ls');
        $command->addArgument(new Argument('test', 'value'));
        $this->assertEquals("ls --test 'value'", (string) $command, 'Command should have arguments');
    }

    public function testCanAddMultipleArguments()
    {
        $command = new Command('ls');
        $command->addArgument(new Argument('test', 'value'));
        $command->addArgument(new Argument('test2', 'value2'));
        $this->assertEquals(
            "ls --test 'value' --test2 'value2'",
            (string) $command,
            'Command should have multiple arguments'
        );
    }

    public function testCanOverrideArguments()
    {
        $command = new Command('ls');
        $command->addArgument(new Argument('test', 'value'));
        $command->addArgument(new Argument('test', 'value2'));
        $this->assertEquals("ls --test 'value2'", (string) $command, 'Arguments should be overwritten');
    }

    public function testCanAddFlag()
    {
        $command = new Command('ls');
        $command->addFlag(new Flag('ll'));
        $this->assertEquals('ls -ll', (string) $command, 'Command should have flags');
    }

    public function testCanAddMultipleFlag()
    {
        $command = new Command('ls');
        $command->addFlag(new Flag('l'));
        $command->addFlag(new Flag('a'));
        $this->assertEquals('ls -l -a', (string) $command, 'Command should have multiple flags');
    }

    public function testCanAddParam()
    {
        $command = new Command('ls');
        $command->addParam(new Param('/'));
        $this->assertEquals("ls '/'", (string) $command, 'Command should have an option');
    }

    public function testCanAddMultipleParams()
    {
        $command = new Command('ls');
        $command->addParam(new Param('/srv'));
        $command->addParam(new Param('/var'));
        $this->assertEquals("ls '/srv' '/var'", (string) $command, 'Command should have multiple options');
    }
}
