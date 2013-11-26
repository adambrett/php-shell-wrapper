<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Flag;

class FlagTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $flag = new Flag('f');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Flag', $flag);
    }

    public function testToString()
    {
        $flag = new Flag('f');
        $this->assertEquals('-f', (string) $flag, 'Flag should cast to a string');
    }
}
