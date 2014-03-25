<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class Exec implements Runner, ReturnValue
{
    protected $output;
    protected $returnValue;

    public function run(CommandInterface $command)
    {
        return exec($command, $this->output, $this->returnValue);
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
