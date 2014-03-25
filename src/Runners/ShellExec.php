<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class ShellExec implements Runner
{
    public function run(CommandInterface $command)
    {
        return shell_exec((string) $command);
    }
}
