<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command\AbstractCommand;

interface Runner
{
    public function run(AbstractCommand $command);
}
