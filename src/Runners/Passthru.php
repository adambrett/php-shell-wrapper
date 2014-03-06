<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\AbstractCommand;

class Passthru implements Runner, ReturnValue
{
    protected $returnValue;

    public function run(AbstractCommand $command)
    {
        return passthru((string) $command, $this->returnValue);
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
