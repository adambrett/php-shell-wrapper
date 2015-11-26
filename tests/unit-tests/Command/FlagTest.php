<?php

namespace AdamBrett\ShellWrapper\Tests\Command;

use AdamBrett\ShellWrapper\Command\Flag;

class FlagTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateInstance()
    {
        $argument = new Flag('test', 'value');
        $this->assertInstanceOf('AdamBrett\ShellWrapper\Command\Flag', $argument);
    }

    public function testToString()
    {
        $argument = new Flag('test', 'value');
        $this->assertEquals("-test 'value'", (string) $argument, 'Flag should cast to a string');
    }

    public function testEscapesArgValue()
    {
        $argument = new Flag('test', '&&');
        $this->assertEquals("-test '&&'", (string) $argument, 'Flag should be escaped');
    }

    public function testGetName()
    {
        $argument = new Flag('test', '&&');
        $this->assertEquals('test', $argument->getName(), 'Flag name should be returned');
    }

    public function testFlagNameEscape()
    {
        $argument = new Flag('test && rm *', 'a b');
        $this->assertEquals('-test\ \&\&\ rm\ \* \'a b\'', (string) $argument, 'Dangerous names should be sanitized');
    }

    public function testFlagNameSanitizeControlCharacters()
    {
        $argument = new Flag("test\r\n");
        $this->assertEquals(
            '-test',
            (string) $argument,
            'Control characters should be stripped from names'
        );
    }

    public function testFlagNameSanitizeControlCharactersUtf8()
    {
        $argument = new Flag("test\r\n\xE2\x80\xA8-\xD8\x9C2");
        $this->assertEquals('-test-2', (string) $argument, 'Control characters should be stripped from names (UTF-8)');
    }

    public function testFlagNameSanitizeNonAsciiNonUtf8()
    {
        $argument = new Flag("t\xC4st\r\n");
        $this->assertEquals(
            '-tst',
            (string) $argument,
            'From non-UTF-8 name strings, all non-ascii characters should be stripped'
        );
    }

    public function testEmptyFlag()
    {
        $argument = new Flag('test');
        $this->assertEquals('-test', (string) $argument, 'Valueless arguments should be allowed');
    }

    public function testMultipleOfSameName()
    {
        $param = new Flag('test', array('value1', 'value2'));
        $this->assertEquals("-test 'value1' -test 'value2'", (string) $param, 'Mutiple flags should be allowed');
    }
}
