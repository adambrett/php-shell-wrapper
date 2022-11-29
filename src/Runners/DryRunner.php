<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class DryRunner extends FakeRunner
{
    public function run(CommandInterface $command): mixed
    {
        echo $command . PHP_EOL;
        return parent::run($command);
    }
}
