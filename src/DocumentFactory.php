<?php

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;
use Safe\Exceptions\FilesystemException;
use function GuzzleHttp\Psr7\stream_for;
use function Safe\fopen;
use function Safe\fwrite;

final class DocumentFactory
{
    /**
     * @param string $fileName
     * @param string $filePath
     * @return Document
     */
    public static function makeFromPath(string $fileName, string $filePath): Document
    {
        return new Document($fileName, new LazyOpenStream($filePath, 'r'));
    }

    /**
     * @param string $fileName
     * @param StreamInterface $fileStream
     * @return Document
     */
    public static function makeFromStream(string $fileName, StreamInterface $fileStream): Document
    {
        return new Document($fileName, $fileStream);
    }

    /**
     * @param string $fileName
     * @param string $string
     * @return Document
     * @throws FilesystemException
     */
    public static function makeFromString(string $fileName, string $string): Document
    {
        $fileStream = fopen('php://memory', 'rb+');
        fwrite($fileStream, $string);
        return new Document($fileName, stream_for($fileStream));
    }
}
