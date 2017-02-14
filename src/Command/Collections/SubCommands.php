<?php

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\SubCommand;

class SubCommands
{
    protected $subCommands = array();

    public function __toString()
    {
        return join(' ', $this->subCommands);
    }

    public function addSubCommand(SubCommand $subCommand)
    {
        $this->subCommands[] = $subCommand;
    }
    
    /**
     * Clone each SubCommand object in the internal list
     */
    public function __clone()
    {
        $subCommandsList = array();
        foreach ($this->subCommands as $subCommand) {
            $subCommandsList[] = clone $subCommand;
        }

        $this->subCommands = $subCommandsList;
    }
}
