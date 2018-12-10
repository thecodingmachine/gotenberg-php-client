<?php

namespace TheCodingMachine\Gotenberg;

use Psr\Http\Message\StreamInterface;

final class Document
{
    /** @var string */
    private $fileName;

    /** @var StreamInterface */
    private $fileStream;

    /**
     * Document constructor.
     * @param string $fileName
     * @param StreamInterface $fileStream
     */
    public function __construct(string $fileName, StreamInterface $fileStream)
    {
        $this->fileName = $fileName;
        $this->fileStream = $fileStream;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return StreamInterface
     */
    public function getFileStream(): StreamInterface
    {
        return $this->fileStream;
    }
}
