<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command\Collections;

use AdamBrett\ShellWrapper\Command\Param;

class Params
{
    protected array $params = [];

    public function __toString()
    {
        return join(' ', $this->params);
    }

    public function __clone()
    {
        $clonedParams = [];
        foreach ($this->params as $param) {
            $clonedParams[] = clone $param;
        }

        $this->params = $clonedParams;
    }

    public function addParam(Param $param): void
    {
        $this->params[] = $param;
    }
}
