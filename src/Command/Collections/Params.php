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

    /**
     * Clone each Params object in the internal list
     */
    public function __clone()
    {
        $clonedParamsList = [];
        foreach ($this->params as $Param) {
            $clonedParamsList[] = clone $Param;
        }

        $this->params = $clonedParamsList;
    }
}
