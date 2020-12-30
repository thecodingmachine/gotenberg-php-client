<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use ErrorException;
use RuntimeException;
use function error_get_last;

class FilesystemException extends ErrorException
{
    public static function createFromPhpError(): self
    {
        $error = error_get_last();

        if ($error === null) {
            throw new RuntimeException('No error information available');
        }

        return new self($error['message'] ?? 'An error occured', 0, $error['type'] ?? 1);
    }
}
