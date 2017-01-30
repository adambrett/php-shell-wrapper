<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\CommandInterface;
use AdamBrett\ShellWrapper\ExitCodes;

/**
 * FakeRunner is intended to test command execution.
 *
 * It only emulate command running and return expected values. Use it when command execution is undesirable
 * e.g. unit tests, running your application with --dry argument
 *
 * You can emulate working of true command through using constructor arguments
 */
class FakeRunner implements Runner, ReturnValue, StandardOut, StandardError
{

    /**
     * @var int One of @see \ShellWrapper\ExitCodes
     */
    private $outputValue;

    /**
     * @var string
     */
    private $standardOutput;

    /**
     * @var string
     */
    private $standardError;

    /**
     * @var string
     */
    private $executedCommand;

    /**
     * FakeRunner constructor.
     *
     * Use arguments for emulating using true Runner
     *
     * @param int $outputValue ExitCode. 0 by default
     * @param string|null $standardOutput strOutput
     * @param string|null $standardError strError
     */
    public function __construct($outputValue = ExitCodes::SUCCESS, $standardOutput = null, $standardError = null)
    {
        $this->outputValue = $outputValue;
        $this->standardOutput = $standardOutput;
        $this->standardError = $standardError;
    }

    /**
     * This command don`t be executed
     *
     * @param CommandInterface $command
     * @return int
     */
    public function run(CommandInterface $command)
    {
        $this->executedCommand = (string) $command;
        return $this->outputValue;
    }

    public function getReturnValue()
    {
        return $this->outputValue;
    }

    public function getStandardError()
    {
        return $this->standardError;
    }

    public function getStandardOut()
    {
        return $this->standardOutput;
    }

    /**
     * String representation of executed command
     *
     * @return string
     */
    public function getExecutedCommand()
    {
        return $this->executedCommand;
    }

}