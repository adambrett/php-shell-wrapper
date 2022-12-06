<?php

declare(strict_types=1);

namespace AdamBrett\ShellWrapper\Tests;

use AdamBrett\ShellWrapper\ExitCodes;
use PHPUnit\Framework\TestCase;

class ExitCodesTest extends TestCase
{
    public function testCannotCreateInstance()
    {
        $this->expectException(\Error::class);
        new ExitCodes();
    }

    public function testGetDescriptionReturnsString()
    {
        $this->assertIsString(
            ExitCodes::getDescription(ExitCodes::SUCCESS),
            'A string should be returned'
        );
        $this->assertIsString(
            ExitCodes::getDescription(ExitCodes::GENERAL_ERROR),
            'A string should be returned'
        );
        $this->assertIsString(
            ExitCodes::getDescription(ExitCodes::BUILTIN_MISUSE),
            'A string should be returned'
        );
        $this->assertIsString(
            ExitCodes::getDescription(ExitCodes::PERMISSION_ERROR),
            'A string should be returned'
        );
        $this->assertIsString(
            ExitCodes::getDescription(ExitCodes::COMMAND_NOT_FOUND),
            'A string should be returned'
        );
        $this->assertIsString(
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
