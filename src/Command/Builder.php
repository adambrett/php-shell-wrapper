<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command;

use AdamBrett\ShellWrapper\Command;

class Builder implements CommandInterface
{
    protected Command $command;

    public function __construct($command)
    {
        $this->command = new Command($command);
    }

    public function __toString()
    {
        return (string)$this->command;
    }

    public function addSubCommand($subCommand): static
    {
        $this->command->addSubCommand(new SubCommand($subCommand));
        return $this;
    }

    public function addArgument($name, $value = null): static
    {
        $this->command->addArgument(new Argument($name, $value));
        return $this;
    }

    public function addFlag($flag, $value = null): static
    {
        $this->command->addFlag(new Flag($flag, $value));
        return $this;
    }

    public function addParam($param): static
    {
        $this->command->addParam(new Param($param));
        return $this;
    }
}
