<?php

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\Param;

class Params
{
    protected $params = array();

    public function __toString()
    {
        return join(' ', $this->params);
    }

    public function addParam(Param $param)
    {
        $this->params[] = $param;
    }
}
