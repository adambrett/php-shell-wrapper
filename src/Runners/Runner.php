<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

interface Runner
{
    public function run(CommandInterface $command);
}
