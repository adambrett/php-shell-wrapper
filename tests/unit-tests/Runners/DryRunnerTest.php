<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests\Runners;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use PHPUnit\Framework\TestCase;

class DryRunnerTest extends TestCase
{
    public function testRun()
    {
        $runner = new DryRunner();
        ob_start();
        $runner->run(new Command('ls'));
        static::assertEquals('ls' . PHP_EOL, ob_get_clean(), 'This runner must print command');

        static::assertEquals(0, $runner->getReturnValue());
    }
}
