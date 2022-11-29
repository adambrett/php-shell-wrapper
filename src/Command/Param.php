<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command;

class Param
{
    public function __construct(protected string $param)
    {
    }

    public function __toString()
    {
        return escapeshellarg($this->param);
    }
}
