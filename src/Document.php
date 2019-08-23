<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use Psr\Http\Message\StreamInterface;

final class Document
{
    /** @var string */
    private $fileName;

    /** @var StreamInterface */
    private $fileStream;

    public function __construct(string $fileName, StreamInterface $fileStream)
    {
        $this->fileName = $fileName;
        $this->fileStream = $fileStream;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFileStream(): StreamInterface
    {
        return $this->fileStream;
    }
}
