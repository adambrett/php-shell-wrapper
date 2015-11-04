<?php

namespace AdamBrett\ShellWrapper\Command;

abstract class Value
{
    protected $name;
    protected $values;

    public function __construct($name, $values = null)
    {
        $this->name = $name;

        if (!is_array($values) && $values !== null) {
            $values = array($values);
        }

        $this->values = $values;
    }

    public function __toString()
    {
        if ($this->values === null) {
            return sprintf('%s%s', static::PREFIX, $this->name);
        }

        return $this->getValuesAsString();
    }

    public function getName()
    {
        return $this->name;
    }

    protected function getValuesAsString()
    {
        $values = array_map('escapeshellarg', $this->values);
        $prefix = sprintf('%s%s ', static::PREFIX, $this->name);
        return $prefix . join(" ${prefix}", $values);
    }
}
