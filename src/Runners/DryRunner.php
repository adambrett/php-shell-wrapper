<?php

namespace AdamBrett\ShellWrapper\Runners;


use AdamBrett\ShellWrapper\Command\CommandInterface;

class DryRunner extends FakeRunner
{
    public function run(CommandInterface $command)
    {
        echo $command."\r\n";
        return parent::run($command);
    }
}
