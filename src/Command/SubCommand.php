<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command;

class SubCommand extends AbstractCommand
{
    public function __toString()
    {
        return $this->command;
    }
}
