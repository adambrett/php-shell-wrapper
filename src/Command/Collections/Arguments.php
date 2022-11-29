<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\Argument;

class Arguments
{
    protected array $arguments = [];

    public function __toString()
    {
        return join(' ', $this->arguments);
    }

    public function addArgument(Argument $argument): void
    {
        $this->arguments[$argument->getName()] = $argument;
    }
}
