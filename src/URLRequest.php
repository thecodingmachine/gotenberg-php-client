<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

final class URLRequest extends ChromeRequest implements GotenbergRequestInterface
{
    private const REMOTE_URL = 'remoteURL';

    private const REMOTE_URL_BASE_HTTP_HEADER_KEY = 'Gotenberg-Remoteurl-';

    /** @var string */
    private $URL;

    public function __construct(string $URL)
    {
        parent::__construct();
        $this->URL = $URL;
    }

    public function getPostURL(): string
    {
        return '/convert/url';
    }

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array
    {
        $values = parent::getFormValues();
        $values[self::REMOTE_URL] = $this->URL;

        return $values;
    }

    public function addRemoteURLHTTPHeader(string $key, string $value): void
    {
        $key = self::REMOTE_URL_BASE_HTTP_HEADER_KEY . $key;
        $this->customHTTPHeaders[$key] = $value;
    }
}
