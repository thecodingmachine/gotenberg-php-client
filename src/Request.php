<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

abstract class Request
{
    public const A3 = [11.7, 16.5];
    public const A4 = [8.27, 11.7];
    public const A5 = [5.8, 8.2];
    public const A6 = [4.1, 5.8];
    public const LETTER = [8.5, 11];
    public const LEGAL = [8.5, 14];
    public const TABLOID = [11, 17];

    public const NO_MARGINS = [0, 0, 0, 0];
    public const NORMAL_MARGINS = [1, 1, 1, 1];
    public const LARGE_MARGINS = [2, 2, 2, 2];

    private const RESULT_FILENAME = 'resultFilename';
    private const WAIT_TIMEOUT = 'waitTimeout';
    private const WEBHOOK_URL = 'webhookURL';
    private const WEBHOOK_URL_TIMEOUT = 'webhookURLTimeout';

    private const WEBHOOK_URL_BASE_HTTP_HEADER_KEY = 'Gotenberg-Webhookurl-';

    /** @var string|null */
    private $resultFilename;

    /** @var float|null */
    private $waitTimeout;

    /** @var string|null */
    private $webhookURL;

    /** @var float|null */
    private $webhookURLTimeout;

    /** @var array<string,string> */
    protected $customHTTPHeaders;

    public function __construct()
    {
        $this->customHTTPHeaders = [];
    }

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array
    {
        $values = [];
        if (! empty($this->resultFilename)) {
            $values[self::RESULT_FILENAME] = $this->resultFilename;
        }
        if ($this->waitTimeout !== null) {
            $values[self::WAIT_TIMEOUT] = $this->waitTimeout;
        }
        if (! empty($this->webhookURL)) {
            $values[self::WEBHOOK_URL] = $this->webhookURL;
        }
        if (! empty($this->webhookURLTimeout)) {
            $values[self::WEBHOOK_URL_TIMEOUT] = $this->webhookURLTimeout;
        }

        return $values;
    }

    public function hasWebhook(): bool
    {
        return ! empty($this->webhookURL);
    }

    /**
     * @return array<string,string>
     */
    public function getCustomHTTPHeaders(): array
    {
        return $this->customHTTPHeaders;
    }

    public function setResultFilename(?string $resultFilename): void
    {
        $this->resultFilename = $resultFilename;
    }

    public function setWaitTimeout(?float $waitTimeout): void
    {
        $this->waitTimeout = $waitTimeout;
    }

    public function setWebhookURL(?string $webhookURL): void
    {
        $this->webhookURL = $webhookURL;
    }

    public function setWebhookURLTimeout(?float $webhookURLTimeout): void
    {
        $this->webhookURLTimeout = $webhookURLTimeout;
    }

    public function addWebhookURLHTTPHeader(string $key, string $value): void
    {
        $key = self::WEBHOOK_URL_BASE_HTTP_HEADER_KEY . $key;
        $this->customHTTPHeaders[$key] = $value;
    }
}
