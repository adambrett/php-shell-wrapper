<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;

class Proc implements Runner, ReturnValue, StandardOut, StandardError
{
    private false|string $stdout;
    private false|string $stderr;
    private int $returnValue;

    private array $descriptorSpec = [
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w']
    ];

    public function run(CommandInterface $command): mixed
    {
        $process = proc_open((string)$command, $this->descriptorSpec, $pipes);

        $this->stdout = stream_get_contents($pipes[1]);
        $this->stderr = stream_get_contents($pipes[2]);

        $this->returnValue = proc_close($process);

        return null;
    }

    public function getReturnValue(): int
    {
        return $this->returnValue;
    }

    public function getStandardOut(): false|string
    {
        return $this->stdout;
    }

    public function getStandardError(): false|string
    {
        return $this->stderr;
    }
}
