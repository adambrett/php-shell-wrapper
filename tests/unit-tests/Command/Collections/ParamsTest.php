<?php

namespace AdamBrett\ShellWrapper\Tests\Command\Collections;

use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Command\Collections\Params as ParamList;

class ParamsTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $paramList = new ParamList();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Collections\Params', $paramList);
    }

    public function testToString()
    {
        $paramList = new ParamList();
        $paramList->addParam(new Param('test'));
        $this->assertEquals("'test'", (string) $paramList, 'ParamList should cast to a string');
    }

    public function testMultipleParams()
    {
        $paramList = new ParamList();
        $paramList->addParam(new Param('hello'));
        $paramList->addParam(new Param('world'));
        $this->assertEquals("'hello' 'world'", (string) $paramList, 'ParamList should have multiple params');
    }

    public function testDuplicateParams()
    {
        $paramList = new ParamList();
        $paramList->addParam(new Param('test'));
        $paramList->addParam(new Param('test'));
        $this->assertEquals("'test' 'test'", (string) $paramList, 'ParamList should allow duplicates');
    }

    public function testClone()
    {
        $paramList1 = new ParamList();
        $paramList1->addParam(new Param('test'));

        $paramList2 = clone $paramList1;
        $paramList2->addParam(new Param('test'));

        $this->assertEquals("'test'", (string) $paramList1, 'Original collection must not be affect by cloned instances');
        $this->assertEquals("'test' 'test'", (string) $paramList2, 'Cloned instances missing some options');
    }
}
