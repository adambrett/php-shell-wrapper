<?php

namespace AdamBrett\ShellWrapper\Command;

abstract class Value
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
            return sprintf('%s%s', static::PREFIX, $this->name);
        }
        return sprintf('%s%s %s', static::PREFIX, $this->name, escapeshellarg($this->value));
    }

    public function getName()
    {
        return $this->name;
    }
}
