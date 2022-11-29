<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command;

abstract class AbstractCommand implements CommandInterface
{
    protected string $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    abstract public function __toString();
}
