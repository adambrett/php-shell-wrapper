<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command;

class ShellExec implements Runner
{
    public function run(Command $command)
    {
        return shell_exec((string) $command);
    }
}
