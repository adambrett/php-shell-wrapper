<?php

namespace AdamBrett\ShellWrapper\Command;

class SubCommand extends AbstractCommand
{
    public function __toString()
    {
        return (string) $this->command;
    }

    public function __clone()
    {
        if ($this->command instanceof CommandInterface) {
            $this->command = clone $this->command;
        }
    }
}
