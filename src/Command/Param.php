<?php

namespace AdamBrett\ShellWrapper\Command;

class Param
{
    protected $param;

    public function __construct($param)
    {
        $this->param = $param;
    }

    public function __toString()
    {
        return escapeshellarg($this->param);
    }
}
