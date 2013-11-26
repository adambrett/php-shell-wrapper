<?php

namespace AdamBrett\ShellWrapper\Command;

class Flag
{
    protected $flag;

    public function __construct($flag)
    {
        $this->flag = $flag;
    }

    public function __toString()
    {
        return sprintf('-%s', $this->flag);
    }
}
