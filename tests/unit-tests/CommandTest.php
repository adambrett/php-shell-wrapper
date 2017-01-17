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

    public function testClone()
    {
        $command1 = new Command('ls');
        $command1->addParam(new Param('/srv'));
        $command1->addSubCommand(new SubCommand('foo'));
        $command1->addArgument(new Argument('h'));

        $command2 = clone $command1;
        $command2->addParam(new Param('/var'));
        $command2->addSubCommand(new SubCommand('bar'));
        $command2->addArgument(new Argument('a'));

        $this->assertEquals("ls foo --h '/srv'", (string) $command1, 'Original command must not be affect by cloned instances');
        $this->assertEquals("ls foo bar --h --a '/srv' '/var'", (string) $command2, 'Cloned instances missing some options');

        $command1 = new Command(new Command('ls'));
        $command2 = clone $command1;
        $this->assertEquals("ls", (string) $command2, 'Cloned instances missing some options');
    }
}
