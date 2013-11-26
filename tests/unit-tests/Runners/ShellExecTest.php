<?php

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Runners\ShellExec;
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\ExitCodes;

class ShellExecTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $shell = new ShellExec();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Runners\ShellExec', $shell);
    }

    public function testCanGetOutput()
    {
        $shell = new ShellExec();
        $output = $shell->run(new Command('ls'));
        $this->assertNotEmpty($output, 'The should be some output');
    }
}
