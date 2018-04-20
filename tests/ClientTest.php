<?php

namespace TheCodingMachine\Gotenberg;

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    const API_URL = 'gotenberg:3000';

    /** @var Document */
    private $officeDocument;

    /** @var Document */
    private $htmlDocument;

    /** @var Document */
    private $markdownDocument;

    /** @var Document */
    private $pdfDocument;

    /** @var Document */
    private $noExtensionDocument;

    public function setUp()
    {
        $this->officeDocument = DocumentFactory::makeFromPath('file.docx', __DIR__ . '/assets/file.docx');
        $this->htmlDocument = DocumentFactory::makeFromPath('file.html', __DIR__ . '/assets/file.html');
        $this->markdownDocument = DocumentFactory::makeFromPath('file.md', __DIR__ . '/assets/file.md');
        $this->pdfDocument = DocumentFactory::makeFromPath('file.pdf', __DIR__ . '/assets/file.pdf');
        $this->noExtensionDocument = DocumentFactory::makeFromPath('file', __DIR__ . '/assets/file.pdf');
    }

    function testForward()
    {
        $client = new Client(self::API_URL, new \Http\Adapter\Guzzle6\Client());

        // case 1: sends a single document.
        $response = $client->forward([$this->officeDocument]);
        $this->assertEquals($response->getHeaderLine('Content-Type'), 'application/pdf');
        $this->assertNotEmpty($response->getBody());

        // case 2: sends many documents.
        $response = $client->forward([
            $this->officeDocument,
            $this->htmlDocument,
            $this->markdownDocument,
            $this->pdfDocument
        ]);
        $this->assertEquals($response->getHeaderLine('Content-Type'), 'application/pdf');
        $this->assertNotEmpty($response->getBody());

    }

    function testStore()
    {
        $client = new Client(self::API_URL);
        $storingPath = __DIR__ . '/store';

        // case 1: sends a single document.
        $filePath = $client->store([$this->officeDocument], $storingPath);
        $this->assertFileExists($filePath);

        // case 2: sends many documents.
        $filePath = $client->store([
            $this->officeDocument,
            $this->htmlDocument,
            $this->markdownDocument,
            $this->pdfDocument
        ], $storingPath);
        $this->assertFileExists($filePath);
    }

    function testClientException()
    {
        $client = new Client(self::API_URL, new \Http\Adapter\Guzzle6\Client());

        $this->expectException(ClientException::class);
        $client->forward([$this->noExtensionDocument]);
    }
}