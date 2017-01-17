<?php

namespace AdamBrett\ShellWrapper\Command;

class SubCommand extends AbstractCommand
{
    public function __toString()
    {
        return $this->command;
    }

    /**
     * To clone internal command instance to avoid error
     */
    public function __clone()
    {
        if ($this->command instanceof CommandInterface) {
            $this->command = clone $this->command;
        }
    }
}
