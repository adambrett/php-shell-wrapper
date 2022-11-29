<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command;

class Param
{
    protected string $param;

    public function __construct($param)
    {
        $this->param = $param;
    }

    public function __toString()
    {
        return escapeshellarg($this->param);
    }
}
