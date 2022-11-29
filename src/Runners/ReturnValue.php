<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Runners;

interface ReturnValue
{
    public function getReturnValue(): ?int;
}
