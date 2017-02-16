<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class Passthru implements Runner, ReturnValue
{
    protected $returnValue;

    public function run(CommandInterface $command)
    {
        $this->returnValue = null;
        return passthru((string) $command, $this->returnValue);
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
