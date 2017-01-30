<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 30.01.17
 * Time: 12:30
 */

namespace AdamBrett\ShellWrapper\Tests\Runners;


use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\EchoFakeRunner;

class EchoFakeRunnerTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $runner = new EchoFakeRunner();
        $runner->run(new Command('ls'));

        static::assertEquals(0, $runner->getReturnValue());
    }
}
