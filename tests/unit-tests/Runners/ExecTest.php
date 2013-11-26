<?php

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\ExitCodes;

class ExecTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $shell = new Exec();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Runners\Exec', $shell);
    }

    public function testCanGetOutput()
    {
        $shell = new Exec();
        $shell->run(new Command('ls'));
        $this->assertNotEmpty($shell->getOutput(), 'The should be some output');
    }

    public function testCanGetReturnValue()
    {
        $shell = new Exec();
        $shell->run(new Command('ls'));

        $this->assertEquals(ExitCodes::SUCCESS, $shell->getReturnValue(), 'The return should be a success');
        $this->assertInternalType('integer', $shell->getReturnValue(), 'The should be a return value');

        $shell->run(new Command('/dev/null 2>/dev/null'));
        $this->assertEquals(ExitCodes::PERMISSION_ERROR, $shell->getReturnValue(), 'The return should be an error');
    }
}
