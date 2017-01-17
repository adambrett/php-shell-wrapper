<?php

namespace AdamBrett\ShellWrapper\Tests\Command\Collections;

use AdamBrett\ShellWrapper\Command\Argument;
use AdamBrett\ShellWrapper\Command\Collections\Arguments as ArgumentList;

class ArgumentsTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $argumentList = new ArgumentList();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Collections\Arguments', $argumentList);
    }

    public function testToString()
    {
        $argumentList = new ArgumentList();
        $argumentList->addArgument(new Argument('test', 'value'));
        $this->assertEquals("--test 'value'", (string) $argumentList, 'ArgumentList should cast to a string');
    }

    public function testMultipleArguments()
    {
        $argumentList = new ArgumentList();
        $argumentList->addArgument(new Argument('test', 'value'));
        $argumentList->addArgument(new Argument('test2', 'value2'));
        $this->assertEquals(
            "--test 'value' --test2 'value2'",
            (string) $argumentList,
            'ArgumentList should have multiple arguments'
        );
    }

    public function testDuplicateArguments()
    {
        $argumentList = new ArgumentList();
        $argumentList->addArgument(new Argument('test', 'value'));
        $argumentList->addArgument(new Argument('test', 'value'));
        $this->assertEquals("--test 'value'", (string) $argumentList, 'ArgumentList should remove duplicates');
    }

    public function testOverwriteArguments()
    {
        $argumentList = new ArgumentList();
        $argumentList->addArgument(new Argument('test', 'value'));
        $argumentList->addArgument(new Argument('test', 'value2'));
        $this->assertEquals("--test 'value2'", (string) $argumentList, 'ArgumentList should overwrite new values');
    }

    public function testClone()
    {
        $argumentList1 = new ArgumentList();
        $argumentList1->addArgument(new Argument('test', 'value'));

        $argumentList2 = clone $argumentList1;
        $argumentList2->addArgument(new Argument('test', 'value2'));
        $argumentList2->addArgument(new Argument('test2', 'value'));

        $this->assertEquals("--test 'value'", (string) $argumentList1, 'Original collection must not be affect by cloned instances');
        $this->assertEquals("--test 'value2' --test2 'value'", (string) $argumentList2, 'Cloned instances missing some options');
    }
}
