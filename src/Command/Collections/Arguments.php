<?php

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\Argument;

class Arguments
{
    protected $arguments = array();

    public function __toString()
    {
        return join(' ', $this->arguments);
    }

    public function addArgument(Argument $argument)
    {
        $this->arguments[$argument->getName()] = $argument;
    }
}
