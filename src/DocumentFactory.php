<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;
use function fopen;
use function fwrite;
use function GuzzleHttp\Psr7\stream_for;

final class DocumentFactory
{
    public static function makeFromPath(string $fileName, string $filePath): Document
    {
        return new Document($fileName, new LazyOpenStream($filePath, 'r'));
    }

    public static function makeFromStream(string $fileName, StreamInterface $fileStream): Document
    {
        return new Document($fileName, $fileStream);
    }

    /**
     * @throws FilesystemException
     */
    public static function makeFromString(string $fileName, string $string): Document
    {
        $fileStream = fopen('php://memory', 'rb+');
        if ($fileStream === false) {
            throw FilesystemException::createFromPhpError();
        }

        if (fwrite($fileStream, $string) === false) {
            throw FilesystemException::createFromPhpError();
        }

        return new Document($fileName, stream_for($fileStream));
    }
}
