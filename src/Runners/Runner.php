<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

interface Runner
{
    public function run(CommandInterface $command): mixed;
}
