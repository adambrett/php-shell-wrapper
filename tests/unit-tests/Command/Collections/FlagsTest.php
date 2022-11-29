<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Command\Collections;

use AdamBrett\ShellWrapper\Command\Collections\Flags as FlagList;
use AdamBrett\ShellWrapper\Command\Flag;
use PHPUnit\Framework\TestCase;

class FlagsTest extends TestCase
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
        $this->assertEquals('-f', (string)$flagList, 'FlagList should cast to a string');
    }

    public function testMultipleFlags()
    {
        $flagList = new FlagList();
        $flagList->addFlag(new Flag('f'));
        $flagList->addFlag(new Flag('z'));
        $this->assertEquals('-f -z', (string)$flagList, 'FlagList should have multiple flags');
    }

    public function testDuplicateFlags()
    {
        $flagList = new FlagList();
        $flagList->addFlag(new Flag('f'));
        $flagList->addFlag(new Flag('f'));
        $this->assertEquals('-f', (string)$flagList, 'FlagList should remove duplicates');
    }

    public function testClone()
    {
        $flagList1 = new FlagList();
        $flagList1->addFlag(new Flag('f'));

        $flagList2 = clone $flagList1;
        $flagList2->addFlag(new Flag('f'));

        $this->assertEquals("-f", (string)$flagList1, 'Original collection must not be affect by cloned instances');
        $this->assertEquals("-f -f", (string)$flagList2, 'Cloned instances missing some options');
    }
}
