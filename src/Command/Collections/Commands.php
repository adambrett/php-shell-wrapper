<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\CommandInterface;
use InvalidArgumentException;

class Commands implements CommandInterface
{
    public const C_AND = '&&';
    public const C_OR = '||';

    private array $commands;
    private mixed $type;

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
        return implode(" $this->type ", $this->commands);
    }
}
