<?php

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\Flag;

class Flags
{
    protected $flags = [];

    public function __toString()
    {
        return join(' ', $this->flags);
    }

    public function addFlag(Flag $flag)
    {
        $this->flags[(string) $flag] = $flag;
    }
}
