<?php

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Runners\Passthru;
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\ExitCodes;

class PassthruTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $shell = new Passthru();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Runners\Passthru', $shell);
    }

    public function testCanGetOutput()
    {
        $shell = new Passthru();
        ob_start();
        $shell->run(new Command('ls'));
        $this->assertNotEmpty(ob_get_clean(), 'The should be some output');
    }

    public function testCanGetReturnValue()
    {
        $shell = new Passthru();
        $shell->run(new Command('ls 1>/dev/null'));

        $this->assertEquals(ExitCodes::SUCCESS, $shell->getReturnValue(), 'The return should be a success');
        $this->assertInternalType('integer', $shell->getReturnValue(), 'The should be a return value');

        $shell->run(new Command('/dev/null 2>/dev/null'));
        $this->assertEquals(ExitCodes::PERMISSION_ERROR, $shell->getReturnValue(), 'The return should be an error');
    }
}
