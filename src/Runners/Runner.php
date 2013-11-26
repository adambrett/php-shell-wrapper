<?php

namespace AdamBrett\ShellWrapper\Runners;

use AdamBrett\ShellWrapper\Command;

interface Runner
{
    public function run(Command $command);
}
