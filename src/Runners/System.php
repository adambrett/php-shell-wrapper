<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class System implements Runner, ReturnValue
{
    protected int|null $returnValue;

    public function run(CommandInterface $command): string|bool
    {
        $this->returnValue = null;
        return system((string)$command, $this->returnValue);
    }

    public function getReturnValue(): ?int
    {
        return $this->returnValue;
    }
}
