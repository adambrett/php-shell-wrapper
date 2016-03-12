<?php

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Runners;
use AdamBrett\ShellWrapper\Command;

class ProcTest extends \PHPUnit_Framework_TestCase
{
    public function createInstance()
    {
        return new Runners\Proc();
    }

    public function testCanCreateInstance()
    {
        $shell = $this->createInstance();
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Runners\Proc', $shell);
    }

    public function testCanGetStandardOutput()
    {
        $shell = $this->createInstance();
        $shell->run(new Command('ls'));
        $this->assertNotEmpty($shell->getStandardOutput(), 'There should be some output');
    }

    public function testCanGetErrorOutput()
    {
        $shell = $this->createInstance();
        $shell->run(new Command('ls --asdasd111testink'));
        $this->assertNotEmpty($shell->getErrorOutput(), 'There should be some output');
    }

    public function testGetsCorrectOutput()
    {
        $shell = $this->createInstance();
        $shell->setDirectory(__DIR__) // Current directory
            ->run(new Command('ls -1')); // One file per line
        $output = $shell->getStandardOutput();
        $this->assertNotEmpty($output, 'There should be some output');
        $files = preg_split("!\n|\r\n|\r!", $output); // Array of filenames
        $this->assertContains(basename(__FILE__), $files, 'Command should detect the test case file');
    }

    public function testCanGetExitCode()
    {
        $shell = $this->createInstance();
        $this->assertInternalType('integer', $shell->run(new Command('ls')), 'Exit type must be an integer');
    }
}
