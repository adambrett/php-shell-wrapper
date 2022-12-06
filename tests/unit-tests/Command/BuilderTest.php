<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Builder as Command;
use AdamBrett\ShellWrapper\Command\CommandInterface;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    public function testCanCreateInstance(): void
    {
        $command = new Command('ls');
        $this->assertInstanceOf(CommandInterface::class, $command);
        $this->assertInstanceOf(Command::class, $command);
    }

    public function testToString(): void
    {
        $command = new Command('ls');
        $this->assertEquals('ls', (string)$command, 'Command should cast to a string');
    }

    public function testCanHaveSubCommand(): void
    {
        $command = new Command('ls');
        $command->addSubCommand('ls');
        $this->assertEquals('ls ls', (string)$command, 'Command should have sub command');
    }

    public function testCanAddArgument(): void
    {
        $command = new Command('ls');
        $command->addArgument('test', 'value');
        $this->assertEquals("ls --test 'value'", (string)$command, 'Command should have arguments');
    }

    public function testCanAddMultipleArguments(): void
    {
        $command = new Command('ls');
        $command->addArgument('test', 'value')
            ->addArgument('test2', 'value2');

        $this->assertEquals(
            "ls --test 'value' --test2 'value2'",
            (string)$command,
            'Command should have multiple arguments'
        );
    }

    public function testCanOverrideArguments(): void
    {
        $command = new Command('ls');
        $command->addArgument('test', 'value')
            ->addArgument('test', 'value2');

        $this->assertEquals("ls --test 'value2'", (string)$command, 'Arguments should be overwritten');
    }

    public function testEmptyArgument(): void
    {
        $command = new Command('ls');
        $command->addArgument('test');
        $this->assertEquals("ls --test", (string)$command, 'Empty arguments should be allowed');
    }

    public function testCanAddFlag(): void
    {
        $command = new Command('ls');
        $command->addFlag('ll');
        $this->assertEquals('ls -ll', (string)$command, 'Command should have flags');
    }

    public function testCanAddFlagValue(): void
    {
        $command = new Command('ls');
        $command->addFlag('f', 'bar');
        $this->assertEquals("ls -f 'bar'", (string)$command, 'Command should have flags');
    }

    public function testCanAddMultipleFlag(): void
    {
        $command = new Command('ls');
        $command->addFlag('l')
            ->addFlag('a');

        $this->assertEquals('ls -l -a', (string)$command, 'Command should have multiple flags');
    }

    public function testCanAddParam(): void
    {
        $command = new Command('ls');
        $command->addParam('/');
        $this->assertEquals("ls '/'", (string)$command, 'Command should have an option');
    }

    public function testCanAddMultipleParams(): void
    {
        $command = new Command('ls');
        $command->addParam('/srv')
            ->addParam('/var');

        $this->assertEquals("ls '/srv' '/var'", (string)$command, 'Command should have multiple options');
    }
}
