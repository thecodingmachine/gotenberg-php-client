<?php

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    function testFeed()
    {
        // case 1: uses a file path.
        $document = new Document('file.pdf');
        $document->feedFromPath(__DIR__ . '/assets/' . $document->getFileName());
        $this->assertNotEmpty($document->getFileStream());

        // case 2: uses a stream.
        $document = new Document('file.pdf');
        $document->feedFromStream(new LazyOpenStream(__DIR__ . '/assets/' . $document->getFileName(), 'r'));
        $this->assertNotEmpty($document->getFileStream());
    }
}