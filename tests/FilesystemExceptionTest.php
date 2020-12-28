<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use ErrorException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use function error_clear_last;
use function fclose;
use function fopen;

class FilesystemExceptionTest extends TestCase
{
    public function testExceptionCanBeCreated(): void
    {
        $fp = fopen('php://memory', 'r');
        fclose($fp);
        @fclose($fp);

        $exception = FilesystemException::createFromPhpError();

        $this->assertInstanceOf(ErrorException::class, $exception);
        $this->assertSame('fclose(): supplied resource is not a valid stream resource', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame(2, $exception->getSeverity());
    }

    public function testExceptionThrownWhenNoError(): void
    {
        error_clear_last();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No error information available');

        FilesystemException::createFromPhpError();
    }
}
