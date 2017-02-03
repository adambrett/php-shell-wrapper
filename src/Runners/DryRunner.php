<?php

namespace AdamBrett\ShellWrapper\Runners;


use AdamBrett\ShellWrapper\Command\CommandInterface;

class DryRunner extends FakeRunner
{
    public function run(CommandInterface $command)
    {
        echo $command.PHP_EOL;
        return parent::run($command);
    }
}
