<?php

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\MultipartStream;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /** @var HttpClient */
    private $client;

    /** @var string */
    private $apiURL;

    /**
     * Client constructor.
     * @param string $apiURL
     * @param HttpClient|null $client
     */
    public function __construct(string $apiURL, HttpClient $client = null)
    {
        $this->apiURL = $apiURL;
        $this->client = $client ?: HttpClientDiscovery::find();
    }

    /**
     * Sends the given documents to the API and returns the response.
     *
     * @param Document[] $documents
     * @return ResponseInterface
     * @throws ClientException
     * @throws \Exception
     * @throws \Http\Client\Exception
     */
    public function forward(array $documents): ResponseInterface
    {
        return $this->handleResponse($this->client->sendRequest($this->makeMultipartFormDataRequest($documents)));
    }

    /**
     * Sends the given documents to the API, stores the resulting PDF in the given storing path
     * and returns the resulting PDF path.
     *
     * @param Document[] $documents
     * @param string $storingPath
     * @return string
     * @throws ClientException
     * @throws \Exception
     * @throws \Http\Client\Exception
     */
    public function store(array $documents, string $storingPath): string
    {
        $response = $this->handleResponse($this->client->sendRequest($this->makeMultipartFormDataRequest($documents)));

        if (!is_dir($storingPath)) {
            mkdir($storingPath);
        }

        $filePath = $storingPath . '/' . uniqid() . '.pdf';
        $fileStream = $response->getBody();

        $fp = fopen($filePath, 'w');
        fwrite($fp, $fileStream);
        fclose($fp);

        return $filePath;
    }

    /**
     * @param Document[] $documents
     * @return RequestInterface
     */
    private function makeMultipartFormDataRequest(array $documents): RequestInterface
    {
        $multipartData = [];

        foreach ($documents as $document) {
            $multipartData[] = [
                'name' => 'files',
                'filename' => $document->getFileName(),
                'contents' => $document->getFileStream()
            ];
        }

        $body = new MultipartStream($multipartData);
        $messageFactory = MessageFactoryDiscovery::find();

        return $messageFactory
            ->createRequest('POST', $this->apiURL)
            ->withHeader('Content-Type', 'multipart/form-data; boundary="' . $body->getBoundary() . '"')
            ->withBody($body);
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws ClientException
     */
    private function handleResponse(ResponseInterface $response): ResponseInterface
    {
        switch ($response->getStatusCode()) {
            case 200:
                return $response;
            default:
                throw new ClientException($response->getBody(), $response->getStatusCode());
        }
    }
}
