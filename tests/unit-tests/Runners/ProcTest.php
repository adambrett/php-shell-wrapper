<?php

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Runners\Proc;
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\ExitCodes;

class ProcTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $shell = new Proc();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Runners\Proc', $shell);
    }

    public function testCanGetStandardOutput()
    {
        $shell = new Proc();
        $shell->run(new Command('ls'));

        $this->assertInternalType('string', $shell->getStandardOut(), 'The should be some output');
        $this->assertNotEmpty($shell->getStandardOut(), 'The should be some output');
    }

    public function testCanGetStandardError()
    {
        $shell = new Proc();
        $shell->run(new Command('ls /root'));

        $this->assertInternalType('string', $shell->getStandardError(), 'The should be some error output');
        $this->assertNotEmpty($shell->getStandardError(), 'The should be some output');
    }

    public function testCanGetReturnValue()
    {
        $shell = new Proc();
        $shell->run(new Command('ls'));
        $this->assertEquals(ExitCodes::SUCCESS, $shell->getReturnValue(), 'The return should be a success');
        $this->assertInternalType('integer', $shell->getReturnValue(), 'The should be a return value');

        $shell->run(new Command('/dev/null 2>/dev/null'));
        $this->assertEquals(ExitCodes::PERMISSION_ERROR, $shell->getReturnValue(), 'The return should be an error');
    }
}
