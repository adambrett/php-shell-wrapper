<?php

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Runners\System;
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\ExitCodes;

class SystemTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $shell = new System();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Runners\System', $shell);
    }

    public function testCanGetOutput()
    {
        $shell = new System();

        ob_start();
        $lastLine = $shell->run(new Command('ls'));
        ob_end_clean();

        $this->assertInternalType('string', $lastLine, 'The should be some output');
    }

    public function testCanGetReturnValue()
    {
        $shell = new System();

        ob_start();
        $shell->run(new Command('ls'));
        ob_end_clean();

        $this->assertEquals(ExitCodes::SUCCESS, $shell->getReturnValue(), 'The return should be a success');
        $this->assertInternalType('integer', $shell->getReturnValue(), 'The should be a return value');

        $shell->run(new Command('/dev/null 2>/dev/null'));
        $this->assertEquals(ExitCodes::PERMISSION_ERROR, $shell->getReturnValue(), 'The return should be an error');
    }
}
