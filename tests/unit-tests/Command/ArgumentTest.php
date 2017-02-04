<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Argument;

class ArgumentTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $argument = new Argument('test', 'value');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Argument', $argument);
    }

    public function testToString()
    {
        $argument = new Argument('test', 'value');
        $this->assertEquals("--test 'value'", (string) $argument, 'Argument should cast to a string');
    }

    public function testEscapesArgValue()
    {
        $argument = new Argument('test', '&&');
        $this->assertEquals("--test '&&'", (string) $argument, 'Argument should be escaped');
    }

    public function testGetName()
    {
        $argument = new Argument('test', '&&');
        $this->assertEquals('test', $argument->getName(), 'Argument name should be returned');
    }

    public function testEmptyArgument()
    {
        $argument = new Argument('test');
        $this->assertEquals('--test', (string) $argument, 'Valueless arguments should be allowed');
    }

    public function testArgumentNameEscape()
    {
        $argument = new Argument('test && rm *', 'a b');
        $this->assertEquals('--test\ \&\&\ rm\ \* \'a b\'', (string) $argument, 'Dangerous names should be sanitized');
    }

    public function testArgumentNameSanitizeControlCharacters()
    {
        $argument = new Argument("test\r\n");
        $this->assertEquals('--test', (string) $argument, 'Control characters should be stripped from names');
    }

    public function testArgumentNameSanitizeControlCharactersUtf8()
    {
        $argument = new Argument("test\r\n\xE2\x80\xA8-\xD8\x9C2");
        $this->assertEquals('--test-2', (string) $argument, 'Control characters should be stripped from names (UTF-8)');
    }

    public function testArgumentNameSanitizeNonAsciiNonUtf8()
    {
        $argument = new Argument("t\xC4st\r\n");
        $this->assertEquals(
            '--tst',
            (string) $argument,
            'From non-UTF-8 name strings, all non-ascii characters should be stripped'
        );
    }

    public function testMultipleOfSameName()
    {
        $param = new Argument('test', array('value1', 'value2'));
        $this->assertEquals("--test 'value1' --test 'value2'", (string) $param, 'Mutiple arguments should be allowed');
    }
}
