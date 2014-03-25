<?php

namespace AdamBrett\ShellWrapper\Command\Collections;

use InvalidArgumentException;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class Command implements CommandInterface
{
    const C_AND = '&&';
    const C_OR = '||';

    private $commands;
    private $type;

    public function __construct(array $commands, $type = self::C_AND)
    {
        foreach ($commands as $command) {
            if (!$command instanceof CommandInterface) {
                throw new InvalidArgumentException('$commands must be an array of CommandInterface');
            }
        }

        $this->commands = $commands;
        $this->type = $type;
    }

    public function __toString()
    {
        return (string) implode(" $this->type ", $this->commands);
    }
}
