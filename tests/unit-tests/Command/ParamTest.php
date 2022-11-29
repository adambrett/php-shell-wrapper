<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Param;
use PHPUnit\Framework\TestCase;

class ParamTest extends TestCase
{
    public function testCanCreateInstance()
    {
        $param = new Param('test');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Param', $param);
    }

    public function testToString()
    {
        $param = new Param('test');
        $this->assertEquals("'test'", (string)$param, 'Param should cast to a string');
    }

    public function testEscapesParam()
    {
        $param = new Param('&&');
        $this->assertEquals("'&&'", (string)$param, 'Param should be escaped');
    }
}
