<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use Exception;
use GuzzleHttp\Psr7\MultipartStream;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function fclose;
use function fopen;
use function fwrite;

final class Client implements GotenbergClientInterface
{
    /** @var HttpClient */
    private $client;

    /** @var string */
    private $apiURL;

    public function __construct(string $apiURL, ?HttpClient $client = null)
    {
        $this->apiURL = $apiURL;
        $this->client = $client ?: HttpClientDiscovery::find();
    }

    /**
     * {@inheritdoc}
     *
     * @throws ClientException
     * @throws Exception
     */
    public function post(GotenbergRequestInterface $request): ResponseInterface
    {
        return $this->handleResponse($this->client->sendRequest($this->makeMultipartFormDataRequest($request)));
    }

    /**
     * {@inheritdoc}
     *
     * @throws ClientException
     * @throws RequestException
     * @throws Exception
     * @throws FilesystemException
     */
    public function store(GotenbergRequestInterface $request, string $destination): void
    {
        if ($request->hasWebhook()) {
            throw new RequestException('Cannot use method store with a webhook.');
        }
        $response = $this->handleResponse($this->client->sendRequest($this->makeMultipartFormDataRequest($request)));
        $fileStream = $response->getBody();
        $fp = fopen($destination, 'w');
        if ($fp === false) {
            throw FilesystemException::createFromPhpError();
        }

        if (fwrite($fp, $fileStream->getContents()) === false) {
            throw FilesystemException::createFromPhpError();
        }

        if (fclose($fp) === false) {
            throw FilesystemException::createFromPhpError();
        }
    }

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
                'contents' => $document->getFileStream(),
            ];
        }
        $body = new MultipartStream($multipartData);
        $messageFactory = MessageFactoryDiscovery::find();
        $message = $messageFactory
            ->createRequest('POST', $this->apiURL . $request->getPostURL())
            ->withHeader('Content-Type', 'multipart/form-data; boundary="' . $body->getBoundary() . '"')
            ->withBody($body);
        foreach ($request->getCustomHTTPHeaders() as $key => $value) {
            $message = $message->withHeader($key, $value);
        }

        return $message;
    }

    /**
     * @throws ClientException
     */
    private function handleResponse(ResponseInterface $response): ResponseInterface
    {
        switch ($response->getStatusCode()) {
            case 200:
                return $response;
            default:
                throw new ClientException($response->getBody()->getContents(), $response->getStatusCode());
        }
    }
}
