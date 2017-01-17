<?php

namespace AdamBrett\ShellWrapper\Tests\Command\Collections;

use AdamBrett\ShellWrapper\Command\SubCommand;
use AdamBrett\ShellWrapper\Command\Collections\SubCommands as SubCommandList;

class SubCommandsTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $subCommandList = new SubCommandList();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Collections\SubCommands', $subCommandList);
    }

    public function testToString()
    {
        $subCommandList = new SubCommandList();
        $subCommandList->addSubCommand(new SubCommand('test'));
        $this->assertEquals('test', (string) $subCommandList, 'SubCommandList should cast to a string');
    }

    public function testMultipleSubCommands()
    {
        $subCommandList = new SubCommandList();
        $subCommandList->addSubCommand(new SubCommand('hello'));
        $subCommandList->addSubCommand(new SubCommand('world'));
        $this->assertEquals('hello world', (string) $subCommandList, 'SubCommandList should have multiple params');
    }

    public function testDuplicateSubCommands()
    {
        $subCommandList = new SubCommandList();
        $subCommandList->addSubCommand(new SubCommand('test'));
        $subCommandList->addSubCommand(new SubCommand('test'));
        $this->assertEquals('test test', (string) $subCommandList, 'SubCommandList should allow duplicates');
    }

    public function testClone()
    {
        $subCommandList1 = new SubCommandList();
        $subCommandList1->addSubCommand(new SubCommand('test'));

        $subCommandList2 = clone $subCommandList1;
        $subCommandList2->addSubCommand(new SubCommand('test'));

        $this->assertEquals('test', (string) $subCommandList1, 'Original collection must not be affect by cloned instances');
        $this->assertEquals('test test', (string) $subCommandList2, 'Cloned instances missing some options');
    }
}
