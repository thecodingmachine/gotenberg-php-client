<?php

namespace TheCodingMachine\Gotenberg;

use GuzzleHttp\Psr7\MultipartStream;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Safe\Exceptions\FilesystemException;
use function Safe\fopen;
use function Safe\fwrite;
use function Safe\fclose;

final class Client
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
     * @param GotenbergRequestInterface $request
     * @return ResponseInterface
     * @throws ClientException
     * @throws \Exception
     */
    public function post(GotenbergRequestInterface $request): ResponseInterface
    {
        return $this->handleResponse($this->client->sendRequest($this->makeMultipartFormDataRequest($request)));
    }

    /**
     * Sends the given documents to the API, stores the resulting PDF in the given destination.
     *
     * @param GotenbergRequestInterface $request
     * @param string $destination
     * @throws ClientException
     * @throws \Exception
     * @throws FilesystemException
     */
    public function store(GotenbergRequestInterface $request, string $destination): void
    {
        $response = $this->handleResponse($this->client->sendRequest($this->makeMultipartFormDataRequest($request)));
        $fileStream = $response->getBody();
        $fp = fopen($destination, 'w');
        fwrite($fp, $fileStream);
        fclose($fp);
    }

    /**
     * @param GotenbergRequestInterface $request
     * @return RequestInterface
     */
    private function makeMultipartFormDataRequest(GotenbergRequestInterface $request): RequestInterface
    {
        $multipartData = [];
        foreach ($request->getFormValues() as $fieldName => $fieldValue) {
            $multipartData[] = [
                'name' => $fieldName,
                'contents' => $fieldValue,
            ];
        }
        /**
         * @var string $filename
         * @var Document $document
         */
        foreach ($request->getFormFiles() as $filename => $document) {
            $multipartData[] = [
                'name' => 'files',
                'filename' => $filename,
                'contents' => $document->getFileStream()
            ];
        }
        $body = new MultipartStream($multipartData);
        $messageFactory = MessageFactoryDiscovery::find();
        return $messageFactory
            ->createRequest('POST', $this->apiURL . $request->getPostURL())
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
