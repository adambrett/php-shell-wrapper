<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Param;

class ParamTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $param = new Param('test');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Param', $param);
    }

    public function testToString()
    {
        $param = new Param('test');
        $this->assertEquals("'test'", (string) $param, 'Param should cast to a string');
    }

    public function testEscapesParam()
    {
        $param = new Param('&&');
        $this->assertEquals("'&&'", (string) $param, 'Param should be escaped');
    }
}
