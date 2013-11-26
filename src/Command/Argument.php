<?php

namespace AdamBrett\ShellWrapper\Command;

class Argument
{
    protected $name;
    protected $value;

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function __toString()
    {
        if ($this->value === null) {
            return sprintf('--%s', $this->name);
        }
        return sprintf('--%s %s', $this->name, escapeshellarg($this->value));
    }

    public function getName()
    {
        return $this->name;
    }
}
