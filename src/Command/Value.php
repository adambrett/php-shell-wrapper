<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Command;

abstract class Value
{
    protected string $name;
    protected array|null $values;

    public function __construct($name, $values = null)
    {
        $this->name = $name;

        if (!is_array($values) && $values !== null) {
            $values = [$values];
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

    protected function getValuesAsString()
    {
        $values = array_map('escapeshellarg', $this->values);
        $prefix = sprintf('%s%s ', static::PREFIX, $this->name);
        return $prefix . join(" ${prefix}", $values);
    }

    public function getName()
    {
        return $this->name;
    }
}
