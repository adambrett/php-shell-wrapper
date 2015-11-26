<?php

namespace AdamBrett\ShellWrapper\Command;

class SubCommand extends AbstractCommand
{
    public function __toString()
    {
        return $this->escape($this->command);
    }

    protected function escape($cmd)
    {
        // strip control characters:
        if (function_exists('mb_detect_encoding') && mb_detect_encoding($cmd, 'UTF-8', true)) {
            $cmd = preg_replace('~\p{C}|\p{Zl}|\p{Zp}~u', '', $cmd);
        } else {
            $cmd = preg_replace('~[[:cntrl:]\x81-\xFF]~', '', $cmd);
        }

        // escape some things to make sure that the SubCommand stays one argument on the shell:
        $cmd = preg_replace('~[^A-Za-z0-9_./{}*?,-]~', '\\' . '\\' . '\\0', $cmd);

        return $cmd;
    }
}
