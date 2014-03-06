<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\AbstractCommand;

class ShellExec implements Runner
{
    public function run(AbstractCommand $command)
    {
        return shell_exec((string) $command);
    }
}
