<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper;

use AdamBrett\ShellWrapper\Command\AbstractCommand;
use AdamBrett\ShellWrapper\Command\Argument;
use AdamBrett\ShellWrapper\Command\Collections\Arguments;
use AdamBrett\ShellWrapper\Command\Collections\Flags;
use AdamBrett\ShellWrapper\Command\Collections\Params;
use AdamBrett\ShellWrapper\Command\Collections\SubCommands;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Command\SubCommand;

class Command extends AbstractCommand
{
    protected Arguments $arguments;
    protected Flags $flags;
    protected Params $params;
    protected SubCommands $subCommands;

    public function __construct(string $command)
    {
        parent::__construct($command);

        $this->arguments = new Arguments();
        $this->flags = new Flags();
        $this->params = new Params();
        $this->subCommands = new SubCommands();
    }

    public function __toString()
    {
        return sprintf(
            '%s%s%s%s%s',
            $this->command,
            $this->pad($this->subCommands),
            $this->pad($this->flags),
            $this->pad($this->arguments),
            $this->pad($this->params)
        );
    }

    private function pad($string): string
    {
        $string = (string)$string;

        if (!empty($string)) {
            return " $string";
        }

        return $string;
    }

    public function addSubCommand(SubCommand $command): void
    {
        $this->subCommands->addSubCommand($command);
    }

    public function addParam(Param $param): void
    {
        $this->params->addParam($param);
    }

    public function addArgument(Argument $argument): void
    {
        $this->arguments->addArgument($argument);
    }

    public function addFlag($name): void
    {
        $this->flags->addFlag($name);
    }

    public function __clone()
    {
        $this->arguments = clone $this->arguments;
        $this->flags = clone $this->flags;
        $this->params = clone $this->params;
        $this->subCommands = clone $this->subCommands;
    }
}
