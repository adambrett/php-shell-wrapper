<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command;

class Passthru implements Runner, ReturnValue
{
    protected $returnValue;

    public function run(Command $command)
    {
        return passthru((string) $command, $this->returnValue);
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
