<?php

namespace AdamBrett\ShellWrapper;

class ExitCodes
{
    const SUCCESS = 0;

    const GENERAL_ERROR = 1;
    const BUILTIN_MISUSE = 2;

    const PERMISSION_ERROR = 126;
    const COMMAND_NOT_FOUND = 127;

    const INVALID_EXIT_ARG = 128;

    const FATAL_ERROR_START = 129;
    const FATAL_ERROR_END = 255;

    const USER_TERMINATED = 130;

    const OUT_OF_RANGE = 255;

    public function __construct()
    {
        throw new \LogicException(__CLASS__ . ' is static and should not be instantiated');
    }

    public static function getDescription($exitCode)
    {
        switch ($exitCode) {
            case self::SUCCESS:
                return 'Success';

            case self::GENERAL_ERROR:
                return 'Catchall for general errors';

            case self::BUILTIN_MISUSE:
                return 'Misuse of shell builtins (according to Bash documentation)';

            case self::PERMISSION_ERROR:
                return 'Permission problem or command is not an executable';

            case self::COMMAND_NOT_FOUND:
                return 'Command not found';

            case self::USER_TERMINATED:
                return 'Script terminated by Control-C';
        }

        if ($exitCode == self::INVALID_EXIT_ARG || $exitCode > self::OUT_OF_RANGE) {
            return 'Exit takes only integer args in the range 0 - 255';
        }

        if ($exitCode > self::FATAL_ERROR_START && $exitCode < self::FATAL_ERROR_END) {
            return 'Fatal error signal "' . ($exitCode - self::FATAL_ERROR_START + 1) . '"';
        }

        return 'Unknown or custom error';
    }
}
