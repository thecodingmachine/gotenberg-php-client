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

    public function setUp()
    {
        $this->officeDocument = $this->makeDocument('file.docx');
        $this->htmlDocument = $this->makeDocument('file.html');
        $this->markdownDocument = $this->makeDocument('file.md');
        $this->pdfDocument = $this->makeDocument('file.pdf');
    }

    private function makeDocument(string $fileName): Document
    {
        $document = new Document($fileName);
        $document->feedFromPath(__DIR__ . '/assets/' . $fileName);

        return $document;
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
        $client = new Client(self::API_URL, new \Http\Adapter\Guzzle6\Client());
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
}