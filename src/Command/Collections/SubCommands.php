<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\SubCommand;

class SubCommands
{
    protected array $subCommands = [];

    public function __toString()
    {
        return join(' ', $this->subCommands);
    }

    public function addSubCommand(SubCommand $subCommand): void
    {
        $this->subCommands[] = $subCommand;
    }

    public function __clone()
    {
        $subCommands = [];
        foreach ($this->subCommands as $subCommand) {
            $subCommands[] = clone $subCommand;
        }

        $this->subCommands = $subCommands;
    }
}
