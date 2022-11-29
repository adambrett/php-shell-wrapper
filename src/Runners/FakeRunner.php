<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;
use AdamBrett\ShellWrapper\ExitCodes;

class FakeRunner implements Runner, ReturnValue, StandardOut, StandardError
{
    private int $outputValue;

    private string|null $standardOutput;

    private string|null $standardError;

    private string|null $executedCommand;

    public function __construct($outputValue = ExitCodes::SUCCESS, $standardOutput = null, $standardError = null)
    {
        $this->outputValue = $outputValue;
        $this->standardOutput = $standardOutput;
        $this->standardError = $standardError;
    }

    public function run(CommandInterface $command): mixed
    {
        $this->executedCommand = (string)$command;
        return $this->outputValue;
    }

    public function getReturnValue(): int
    {
        return $this->outputValue;
    }

    public function getStandardError(): ?string
    {
        return $this->standardError;
    }

    public function getStandardOut(): ?string
    {
        return $this->standardOutput;
    }

    public function getExecutedCommand(): ?string
    {
        return $this->executedCommand;
    }
}
