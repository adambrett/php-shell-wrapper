<?php

namespace AdamBrett\ShellWrapper\Tests\Command\Collections;

use AdamBrett\ShellWrapper\Command\Flag;
use AdamBrett\ShellWrapper\Command\Collections\Flags as FlagList;

class FlagsTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $flagList = new FlagList();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Collections\Flags', $flagList);
    }

    public function testToString()
    {
        $flagList = new FlagList();
        $flagList->addFlag(new Flag('f'));
        $this->assertEquals('-f', (string) $flagList, 'FlagList should cast to a string');
    }

    public function testMultipleFlags()
    {
        $flagList = new FlagList();
        $flagList->addFlag(new Flag('f'));
        $flagList->addFlag(new Flag('z'));
        $this->assertEquals('-f -z', (string) $flagList, 'FlagList should have multiple flags');
    }

    public function testDuplicateFlags()
    {
        $flagList = new FlagList();
        $flagList->addFlag(new Flag('f'));
        $flagList->addFlag(new Flag('f'));
        $this->assertEquals('-f', (string) $flagList, 'FlagList should remove duplicates');
    }
}
