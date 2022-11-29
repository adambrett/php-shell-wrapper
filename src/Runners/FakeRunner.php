<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;
use AdamBrett\ShellWrapper\ExitCodes;

class FakeRunner implements Runner, ReturnValue, StandardOut, StandardError
{
    private string|null $executedCommand;

    public function __construct(
        private readonly int $outputValue = ExitCodes::SUCCESS,
        private readonly string|null $standardOutput = null,
        private readonly string|null $standardError = null
    ) {
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

    public function getStandardError(): mixed
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
