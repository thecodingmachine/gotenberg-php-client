<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;
use Safe\Exceptions\FilesystemException;
use function GuzzleHttp\Psr7\stream_for;
use function Safe\fopen;
use function Safe\fwrite;

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
        fwrite($fileStream, $string);

        return new Document($fileName, stream_for($fileStream));
    }
}
