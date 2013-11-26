<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command;

class System implements Runner, ReturnValue
{
    protected $returnValue;

    public function run(Command $command)
    {
        return system((string) $command, $this->returnValue);
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
