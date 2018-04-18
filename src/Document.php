<?php

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use Psr\Http\Message\StreamInterface;

class Document
{
    /** @var string */
    private $fileName;

    /** @var StreamInterface */
    private $fileStream;

    /**
     * Document constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param string $filePath
     */
    public function feedFromPath(string $filePath): void
    {
        $this->fileStream = new LazyOpenStream($filePath, 'r');
    }

    /**
     * @param StreamInterface $fileStream
     */
    public function feedFromStream(StreamInterface $fileStream): void
    {
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
     * @param string $fileName
     * @return Document
     */
    public function setFileName(string $fileName): Document
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return StreamInterface
     */
    public function getFileStream(): StreamInterface
    {
        return $this->fileStream;
    }
}
