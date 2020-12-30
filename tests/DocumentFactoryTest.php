<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\LazyOpenStream;
use PHPUnit\Framework\TestCase;

final class DocumentFactoryTest extends TestCase
{
    /**
     * @throws FilesystemException
     */
    public function testMake(): void
    {
        // case 1: uses a file path.
        $document = DocumentFactory::makeFromPath('file.pdf', __DIR__ . '/assets/file.pdf');
        $this->assertNotEmpty($document->getFileStream());
        // case 2: uses a stream.
        $document = DocumentFactory::makeFromStream('file.pdf', new LazyOpenStream(__DIR__ . '/assets/file.pdf', 'r'));
        $this->assertNotEmpty($document->getFileStream());
        // case 3: uses a string
        $document = DocumentFactory::makeFromString('index.html', '<html>foo</html>');
        $this->assertNotEmpty($document->getFileStream());
    }
}
