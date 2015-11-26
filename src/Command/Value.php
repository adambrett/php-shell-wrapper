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
            return sprintf('%s%s', static::PREFIX, $this->sanitizeName($this->name));
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
        $prefix = sprintf('%s%s ', static::PREFIX, $this->sanitizeName($this->name));
        return $prefix . join(" ${prefix}", $values);
    }

    protected function sanitizeName($name)
    {
        // strip control characters:
        if (function_exists('mb_detect_encoding') && mb_detect_encoding($name, 'UTF-8', true)) {
            $name = preg_replace('~\p{C}|\p{Zl}|\p{Zp}~u', '', $name);
        } else {
            $name = preg_replace('~[[:cntrl:]\x81-\xFF]~', '', $name);
        }

        // escape some things to make sure that the name stays one argument on the shell:
        $name = preg_replace('~[^A-Za-z0-9_./-]~', '\\' . '\\' . '\\0', $name);

        return $name;
    }
}
