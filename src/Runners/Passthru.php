<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class Passthru implements Runner, ReturnValue
{
    protected int|null $returnValue;

    public function run(CommandInterface $command): ?bool
    {
        $this->returnValue = null;
        return passthru((string)$command, $this->returnValue);
    }

    public function getReturnValue(): ?int
    {
        return $this->returnValue;
    }
}
