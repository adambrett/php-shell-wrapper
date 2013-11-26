<?php

namespace AdamBrett\ShellWrapper\Command;

use AdamBrett\ShellWrapper\Command;

class Builder
{
    protected $command;

    public function __construct($command)
    {
        $this->command = new Command($command);
    }

    public function __toString()
    {
        return (string) $this->command;
    }

    public function addSubCommand($subCommand)
    {
        $this->command->addSubCommand(new SubCommand($subCommand));
        return $this;
    }

    public function addArgument($name, $value = null)
    {
        $this->command->addArgument(new Argument($name, $value));
        return $this;
    }

    public function addFlag($flag)
    {
        $this->command->addFlag(new Flag($flag));
        return $this;
    }

    public function addParam($param)
    {
        $this->command->addParam(new Param($param));
        return $this;
    }
}
