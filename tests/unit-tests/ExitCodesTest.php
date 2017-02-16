<?php

namespace AdamBrett\ShellWrapper\Tests;

use AdamBrett\ShellWrapper\ExitCodes;

class ExitCodesTest extends \PHPUnit_Framework_TestCase
{
    public function testCannotCreateInstance()
    {
        $this->setExpectedException('\LogicException');
        new ExitCodes();
    }

    public function testGetDescriptionReturnsString()
    {
        $this->assertInternalType(
            'string',
            ExitCodes::getDescription(ExitCodes::SUCCESS),
            'A string should be returned'
        );
        $this->assertInternalType(
            'string',
            ExitCodes::getDescription(ExitCodes::GENERAL_ERROR),
            'A string should be returned'
        );
        $this->assertInternalType(
            'string',
            ExitCodes::getDescription(ExitCodes::BUILTIN_MISUSE),
            'A string should be returned'
        );
        $this->assertInternalType(
            'string',
            ExitCodes::getDescription(ExitCodes::PERMISSION_ERROR),
            'A string should be returned'
        );
        $this->assertInternalType(
            'string',
            ExitCodes::getDescription(ExitCodes::COMMAND_NOT_FOUND),
            'A string should be returned'
        );
        $this->assertInternalType(
            'string',
            ExitCodes::getDescription(ExitCodes::USER_TERMINATED),
            'A string should be returned'
        );
    }

    public function test3To125AreUnknownOrCustom()
    {
        $this->assertEquals(
            'Unknown or custom error',
            ExitCodes::getDescription(3)
        );

        $this->assertEquals(
            'Unknown or custom error',
            ExitCodes::getDescription(95)
        );

        $this->assertEquals(
            'Unknown or custom error',
            ExitCodes::getDescription(125)
        );
    }

    public function testInvalidExitArgRange()
    {
        $this->assertEquals(
            'Exit takes only integer args in the range 0 - 255',
            ExitCodes::getDescription(128)
        );

        $this->assertEquals(
            'Exit takes only integer args in the range 0 - 255',
            ExitCodes::getDescription(300)
        );
    }

    public function testFatalErrorRange()
    {
        $this->assertEquals(
            'Fatal error signal "9"',
            ExitCodes::getDescription(137)
        );

        $this->assertEquals(
            'Fatal error signal "57"',
            ExitCodes::getDescription(185)
        );
    }
}
