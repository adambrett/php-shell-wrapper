<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Integration\Command;

use AdamBrett\ShellWrapper\Command\Builder as CommandBuilder;
use AdamBrett\ShellWrapper\Runners\Exec;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    protected string $testFile;

    public function setUp(): void
    {
        $this->testFile = __DIR__ . '/.testFile';
        $this->cleanUp();
    }

    protected function cleanUp()
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }
    }

    public function tearDown(): void
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
}
