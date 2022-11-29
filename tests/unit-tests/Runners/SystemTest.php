<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\ExitCodes;
use AdamBrett\ShellWrapper\Runners\System;
use PHPUnit\Framework\TestCase;

class SystemTest extends TestCase
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

        $this->assertIsString($lastLine, 'The should be some output');
    }

    public function testCanGetReturnValue()
    {
        $shell = new System();

        ob_start();
        $shell->run(new Command('ls'));
        ob_end_clean();

        $this->assertEquals(ExitCodes::SUCCESS, $shell->getReturnValue(), 'The return should be a success');
        $this->assertIsInt($shell->getReturnValue(), 'The should be a return value');

        $shell->run(new Command('/dev/null 2>/dev/null'));
        $this->assertEquals(ExitCodes::PERMISSION_ERROR, $shell->getReturnValue(), 'The return should be an error');
    }
}
