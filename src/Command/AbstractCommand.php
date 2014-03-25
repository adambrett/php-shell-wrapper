<?php

namespace AdamBrett\ShellWrapper\Command;

abstract class AbstractCommand implements CommandInterface
{
    protected $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    abstract public function __toString();
}
