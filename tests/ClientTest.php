<?php

namespace TheCodingMachine\Gotenberg;

use PHPUnit\Framework\TestCase;
use Safe\Exceptions\FilesystemException;

class ClientTest extends TestCase
{
    const API_URL = 'gotenberg:3000';

    /** @var HTMLRequest */
    private $HTMLRequest;

    /** @var MarkdownRequest */
    private $markdownRequest;

    /** @var OfficeRequest */
    private $officeRequest;

    /** @var MergeRequest */
    private $mergeRequest;

    /**
     * @throws RequestException
     */
    public function setUp()
    {
        $this->HTMLRequest = $this->createHTMLRequest();
        $this->markdownRequest = $this->createMarkdownRequest();
        $this->officeRequest = $this->createOfficeRequest();
        $this->mergeRequest = $this->createMergeRequest();
    }

    /**
     * @return HTMLRequest
     * @throws RequestException
     */
    private function createHTMLRequest(): HTMLRequest
    {
        $index = DocumentFactory::makeFromPath('index.html', __DIR__ . '/assets/html/index.html');
        $header = DocumentFactory::makeFromPath('header.html', __DIR__ . '/assets/html/header.html');
        $footer = DocumentFactory::makeFromPath('footer.html', __DIR__ . '/assets/html/footer.html');
        $assets = [
            DocumentFactory::makeFromPath('font.woff', __DIR__ . '/assets/html/font.woff'),
            DocumentFactory::makeFromPath('img.gif', __DIR__ . '/assets/html/img.gif'),
            DocumentFactory::makeFromPath('style.css', __DIR__ . '/assets/html/style.css'),
        ];
        $request = new HTMLRequest($index);
        $request->setHeader($header);
        $request->setFooter($footer);
        $request->setAssets($assets);
        $request->setPaperSize(Request::A4);
        $request->setMargins(Request::NO_MARGINS);
        return $request;
    }

    /**
     * @return MarkdownRequest
     * @throws RequestException
     */
    public function createMarkdownRequest(): MarkdownRequest
    {
        $index = DocumentFactory::makeFromPath('index.html', __DIR__ . '/assets/markdown/index.html');
        $markdowns = [
            DocumentFactory::makeFromPath('paragraph1.md', __DIR__ . '/assets/markdown/paragraph1.md'),
            DocumentFactory::makeFromPath('paragraph2.md', __DIR__ . '/assets/markdown/paragraph2.md'),
            DocumentFactory::makeFromPath('paragraph3.md', __DIR__ . '/assets/markdown/paragraph3.md'),
        ];
        $header = DocumentFactory::makeFromPath('header.html', __DIR__ . '/assets/markdown/header.html');
        $footer = DocumentFactory::makeFromPath('footer.html', __DIR__ . '/assets/markdown/footer.html');
        $assets = [
            DocumentFactory::makeFromPath('font.woff', __DIR__ . '/assets/markdown/font.woff'),
            DocumentFactory::makeFromPath('img.gif', __DIR__ . '/assets/markdown/img.gif'),
            DocumentFactory::makeFromPath('style.css', __DIR__ . '/assets/markdown/style.css'),
        ];
        $request = new MarkdownRequest($index, $markdowns);
        $request->setHeader($header);
        $request->setFooter($footer);
        $request->setAssets($assets);
        $request->setPaperSize(Request::A4);
        $request->setMargins(Request::NO_MARGINS);
        return $request;
    }

    /**
     * @return OfficeRequest
     */
    public function createOfficeRequest(): OfficeRequest
    {
        $files = [
            DocumentFactory::makeFromPath('document.docx', __DIR__ . '/assets/office/document.docx'),
        ];
        $request = new OfficeRequest($files);
        return $request;
    }

    /**
     * @return MergeRequest
     */
    public function createMergeRequest(): MergeRequest
    {
        $files = [
            DocumentFactory::makeFromPath('gotenberg.pdf', __DIR__ . '/assets/pdf/gotenberg.pdf'),
            DocumentFactory::makeFromPath('gotenberg2.pdf', __DIR__ . '/assets/pdf/gotenberg.pdf'),
        ];
        $request = new MergeRequest($files);
        return $request;
    }

    /**
     * @throws ClientException
     * @throws FilesystemException
     */
    function testPost()
    {
        $client = new Client(self::API_URL, new \Http\Adapter\Guzzle6\Client());
        // case 1: HTML.
        $response = $client->post($this->HTMLRequest);
        $this->assertEquals($response->getHeaderLine('Content-Type'), 'application/pdf');
        $this->assertNotEmpty($response->getBody());
        // case 2: markdown.
        $response = $client->post($this->markdownRequest);
        $this->assertEquals($response->getHeaderLine('Content-Type'), 'application/pdf');
        $this->assertNotEmpty($response->getBody());
        // case 3: office.
        $response = $client->post($this->officeRequest);
        $this->assertEquals($response->getHeaderLine('Content-Type'), 'application/pdf');
        $this->assertNotEmpty($response->getBody());
        // case 4: merge.
        $response = $client->post($this->mergeRequest);
        $this->assertEquals($response->getHeaderLine('Content-Type'), 'application/pdf');
        $this->assertNotEmpty($response->getBody());
    }

    /**
     * @throws ClientException
     * @throws FilesystemException
     */
    function testStore()
    {
        $client = new Client(self::API_URL);
        $storingPath = __DIR__ . '/store';
        // case 1: HTML.
        $filePath = $client->store($this->HTMLRequest, $storingPath);
        $this->assertFileExists($filePath);
        // case 2: markdown.
        $filePath = $client->store($this->markdownRequest, $storingPath);
        $this->assertFileExists($filePath);
        // case 3: office.
        $filePath = $client->store($this->officeRequest, $storingPath);
        $this->assertFileExists($filePath);
        // case 4: merge.
        $filePath = $client->store($this->mergeRequest, $storingPath);
        $this->assertFileExists($filePath);
    }
}