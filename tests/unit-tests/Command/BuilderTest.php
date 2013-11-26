<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Builder as Command;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $command = new Command('ls');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Builder', $command);
    }

    public function testToString()
    {
        $command = new Command('ls');
        $this->assertEquals('ls', (string) $command, 'Command should cast to a string');
    }

    public function testCanHaveSubCommand()
    {
        $command = new Command('ls');
        $command->addSubCommand('ls');
        $this->assertEquals('ls ls', (string) $command, 'Command should have sub command');
    }

    public function testCanAddArgument()
    {
        $command = new Command('ls');
        $command->addArgument('test', 'value');
        $this->assertEquals("ls --test 'value'", (string) $command, 'Command should have arguments');
    }

    public function testCanAddMultipleArguments()
    {
        $command = new Command('ls');
        $command->addArgument('test', 'value')
            ->addArgument('test2', 'value2');

        $this->assertEquals(
            "ls --test 'value' --test2 'value2'",
            (string) $command,
            'Command should have multiple arguments'
        );
    }

    public function testCanOverrideArguments()
    {
        $command = new Command('ls');
        $command->addArgument('test', 'value')
            ->addArgument('test', 'value2');

        $this->assertEquals("ls --test 'value2'", (string) $command, 'Arguments should be overwritten');
    }

    public function testEmptyArgument()
    {
        $command = new Command('ls');
        $command->addArgument('test');
        $this->assertEquals("ls --test", (string) $command, 'Empty arguments should be allowed');
    }

    public function testCanAddFlag()
    {
        $command = new Command('ls');
        $command->addFlag('ll');
        $this->assertEquals('ls -ll', (string) $command, 'Command should have flags');
    }

    public function testCanAddMultipleFlag()
    {
        $command = new Command('ls');
        $command->addFlag('l')
            ->addFlag('a');

        $this->assertEquals('ls -l -a', (string) $command, 'Command should have multiple flags');
    }

    public function testCanAddParam()
    {
        $command = new Command('ls');
        $command->addParam('/');
        $this->assertEquals("ls '/'", (string) $command, 'Command should have an option');
    }

    public function testCanAddMultipleParams()
    {
        $command = new Command('ls');
        $command->addParam('/srv')
            ->addParam('/var');

        $this->assertEquals("ls '/srv' '/var'", (string) $command, 'Command should have multiple options');
    }
}
