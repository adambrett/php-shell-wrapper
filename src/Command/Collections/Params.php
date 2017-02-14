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

    /**
     * Clone each Params object in the internal list
     */
    public function __clone()
    {
        $clonedParamsList = array();
        foreach ($this->params as $param) {
            $clonedParamsList[] = clone $param;
        }

        $this->params = $clonedParamsList;
    }

    public function addParam(Param $param)
    {
        $this->params[] = $param;
    }
}
