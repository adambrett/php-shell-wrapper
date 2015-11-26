<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\SubCommand;

class SubCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $command = new SubCommand('ls');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\SubCommand', $command);
    }

    public function testToString()
    {
        $command = new SubCommand('ls');
        $this->assertEquals('ls', (string) $command, 'SubCommand should cast to a string');
    }

    public function testSimpleNoEscape()
    {
        $command = new SubCommand('do-some-stuff');
        $this->assertEquals('do-some-stuff', (string)$command, 'SubCommand should not escape simple strings');
    }

    public function testDangerousEscape()
    {
        $command = new SubCommand('do-some-stuff --with-flags && rm /dev/null # comment stop');
        $this->assertEquals(
            'do-some-stuff\ --with-flags\ \&\&\ rm\ /dev/null\ \#\ comment\ stop',
            (string)$command,
            'SubCommand should create exactly one shell argument'
        );
    }

    public function testAllowShellWildcards()
    {
        $command = new SubCommand('test stuff/{todo/*,.x??}');
        $this->assertEquals('test\ stuff/{todo/*,.x??}', (string)$command, 'SubCommand should allow shell wild cards');
    }

    public function testControlCharactersRemoval()
    {
        $command = new SubCommand("do-\rsome\f-stuff\n");
        $this->assertEquals('do-some-stuff', (string)$command, 'SubCommand should remove control characters');
    }

    public function testControlCharactersRemovalUtf8()
    {
        $command = new SubCommand("do\xE2\x80\xA8-\xD8\x9Cstuff\n");
        $this->assertEquals(
            'do-stuff',
            (string)$command,
            'SubCommand should remove unicode control characters from UTF-8 strings'
        );
    }

    public function testControlCharactersRemovalNonAsciiNonUtf8()
    {
        $command = new SubCommand("T\xC4ST &&\r\nstop");
        $this->assertEquals(
            'TST\ \&\&stop',
            (string)$command,
            'SubCommand should remove all non-ascii characters from non-UTF-8 strings'
        );
    }
}
