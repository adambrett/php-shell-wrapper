<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 30.01.17
 * Time: 12:07
 */

namespace AdamBrett\ShellWrapper\Runners;


use AdamBrett\ShellWrapper\Command\CommandInterface;
use AdamBrett\ShellWrapper\Runners\FakeRunner;

class EchoFakeRunner extends FakeRunner
{
    public function run(CommandInterface $command)
    {
        echo $command;
        return parent::run($command);
    }

}