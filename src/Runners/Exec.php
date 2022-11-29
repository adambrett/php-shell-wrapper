<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class Exec implements Runner, ReturnValue
{
    protected array|null $output;
    protected int|null $returnValue;

    public function run(CommandInterface $command): string|bool
    {
        $this->output = null;
        $this->returnValue = null;
        return exec((string)$command, $this->output, $this->returnValue);
    }

    public function getOutput(): ?array
    {
        return $this->output;
    }

    public function getReturnValue(): ?int
    {
        return $this->returnValue;
    }
}
