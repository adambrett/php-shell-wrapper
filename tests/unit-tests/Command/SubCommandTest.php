<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\SubCommand;
use PHPUnit\Framework\TestCase;

class SubCommandTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $command = new SubCommand('ls');
        $this->assertInstanceOf(SubCommand::class, $command);
    }

    public function testToString()
    {
        $command = new SubCommand('ls');
        $this->assertEquals('ls', (string)$command, 'SubCommand should cast to a string');
    }

    public function testClone()
    {
        $subCommand1 = new SubCommand((string)new SubCommand('ls'));
        $subCommand2 = clone $subCommand1;
        $this->assertEquals("ls", (string)$subCommand2, 'Cloned instances missing some options');
    }
}
