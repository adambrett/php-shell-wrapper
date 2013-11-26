<?php

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\SubCommand;

class SubCommands
{
    protected $subCommands = [];

    public function __toString()
    {
        return join(' ', $this->subCommands);
    }

    public function addSubCommand(SubCommand $subCommand)
    {
        $this->subCommands[] = $subCommand;
    }
}
