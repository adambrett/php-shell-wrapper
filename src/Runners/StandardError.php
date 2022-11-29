<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

interface StandardError
{
    public function getStandardError(): mixed;
}
