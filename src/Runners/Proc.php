<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class Proc implements Runner, ReturnValue, StandardOut, StandardError
{
    private $stdout;
    private $stderr;
    private $returnValue;

    private $descriptorSpec = array(
        1 => array('pipe', 'w'),
        2 => array('pipe', 'w')
    );

    public function run(CommandInterface $command)
    {
        $process = proc_open((string) $command, $this->descriptorSpec, $pipes);

        $this->stdout = stream_get_contents($pipes[1]);
        $this->stderr = stream_get_contents($pipes[2]);

        $this->returnValue = proc_close($process);
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }

    public function getStandardOut()
    {
        return $this->stdout;
    }

    public function getStandardError()
    {
        return $this->stderr;
    }
}
