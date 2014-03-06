<?php

namespace AdamBrett\ShellWrapper\Tests\Integration\Command;

use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;

use PHPUnit_Framework_TestCase;

class BuilderTest extends PHPUnit_Framework_TestCase
{
    protected $testFile;

    public function setUp()
    {
        $this->testFile = __DIR__ . '/.testFile';
        $this->cleanUp();
    }

    public function tearDown()
    {
        $this->cleanUp();
    }

    public function testExecRunsCommandBuilder()
    {
        $shell = new Exec();
        $command = new CommandBuilder('touch');
        $command->addParam($this->testFile);
        $shell->run($command);

        $this->assertTrue(
            file_exists($this->testFile),
            sprintf('%s should have been created', $this->testFile)
        );
    }

    protected function cleanUp()
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }
    }
}
