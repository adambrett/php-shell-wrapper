<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\ExitCodes;
use AdamBrett\ShellWrapper\Runners\Proc;
use PHPUnit\Framework\TestCase;

class ProcTest extends TestCase
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

        $this->assertIsString($shell->getStandardOut(), 'The should be some output');
        $this->assertNotEmpty($shell->getStandardOut(), 'The should be some output');
    }

    public function testCanGetStandardError()
    {
        $shell = new Proc();
        $shell->run(new Command('ls /root'));

        $this->assertIsString($shell->getStandardError(), 'The should be some error output');
        $this->assertNotEmpty($shell->getStandardError(), 'The should be some output');
    }

    public function testCanGetReturnValue()
    {
        $shell = new Proc();
        $shell->run(new Command('ls'));
        $this->assertEquals(ExitCodes::SUCCESS, $shell->getReturnValue(), 'The return should be a success');
        $this->assertIsInt($shell->getReturnValue(), 'The should be a return value');

        $shell->run(new Command('/dev/null 2>/dev/null'));
        $this->assertEquals(ExitCodes::PERMISSION_ERROR, $shell->getReturnValue(), 'The return should be an error');
    }
}
