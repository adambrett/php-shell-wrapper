<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class ShellExec implements Runner
{
    protected string $output;

    public function run(CommandInterface $command): string|bool|null
    {
        return shell_exec((string)$command);
    }
}
