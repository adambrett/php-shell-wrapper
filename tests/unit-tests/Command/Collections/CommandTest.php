<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Command\Collections;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Command\Collections\Commands as Commands;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $commandsArray = [];
        $commands = new Commands($commandsArray);
        $this->assertInstanceOf(Commands::class, $commands);
    }

    public function testToStringAnd()
    {
        $commandsArray = [new Command('cd'), new Command('ls')];
        $commands = new Commands($commandsArray);
        $this->assertEquals('cd && ls', (string)$commands, 'Commands should be joined by and');
    }

    public function testToStringOr()
    {
        $commandsArray = [new Command('cd'), new Command('ls')];
        $commands = new Commands($commandsArray, Commands::C_OR);
        $this->assertEquals('cd || ls', (string)$commands, 'Commands should be joined by or');
    }

    public function testChainedCommands()
    {
        $andCommandsArray = [new Command('cd'), new Command('ls')];
        $and = new Commands($andCommandsArray);
        $orCommandsArray = [$and, new Command('ls')];
        $or = new Commands($orCommandsArray, Commands::C_OR);
        $this->assertEquals('cd && ls || ls', (string)$or, 'Commands should be joined by and and or');
    }

    public function testCommandsRequireCommandInterface()
    {
        $this->expectException(\InvalidArgumentException::class);
        $commandsArray = ['ls'];
        new Commands($commandsArray);
    }
}
