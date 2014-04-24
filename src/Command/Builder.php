<?php

namespace AdamBrett\ShellWrapper\Command;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Command\AbstractCommand;

class Builder extends AbstractCommand
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

    public function addFlag($flag, $value = null)
    {
        $this->command->addFlag(new Flag($flag, $value));
        return $this;
    }

    public function addParam($param)
    {
        $this->command->addParam(new Param($param));
        return $this;
    }
}
