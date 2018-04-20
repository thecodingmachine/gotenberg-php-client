<?php

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;

class DocumentFactory
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
}
