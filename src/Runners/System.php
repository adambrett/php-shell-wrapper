<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\AbstractCommand;

class System implements Runner, ReturnValue
{
    protected $returnValue;

    public function run(AbstractCommand $command)
    {
        return system((string) $command, $this->returnValue);
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
