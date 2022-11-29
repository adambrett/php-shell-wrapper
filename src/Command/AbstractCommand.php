<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command;

abstract class AbstractCommand implements CommandInterface
{
    public function __construct(protected string $command)
    {
    }

    abstract public function __toString();
}
