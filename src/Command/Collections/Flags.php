<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\Flag;

class Flags
{
    protected array $flags = [];

    public function __toString()
    {
        return join(' ', $this->flags);
    }

    public function addFlag(Flag $flag): void
    {
        $this->flags[(string)$flag] = $flag;
    }

    public function __clone()
    {
        $clonedFlags = [];
        foreach ($this->flags as $flag) {
            $clonedFlags[] = clone $flag;
        }

        $this->flags = $clonedFlags;
    }
}
