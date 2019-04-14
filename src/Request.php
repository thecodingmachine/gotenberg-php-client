<?php

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

    /** @var string|null */
    private $resultFilename;

    /** @var float|null */
    private $waitTimeout;

    /** @var string|null */
    private $webhookURL;

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array
    {
        $values = [];
        if (!empty($this->resultFilename)) {
            $values[self::RESULT_FILENAME] = $this->resultFilename;
        }
        if (!is_null($this->waitTimeout)) {
            $values[self::WAIT_TIMEOUT] = $this->waitTimeout;
        }
        if (!empty($this->webhookURL)) {
            $values[self::WEBHOOK_URL] = $this->webhookURL;
        }
        return $values;
    }

    /**
     * @param string|null $resultFilename
     */
    public function setResultFilename(?string $resultFilename): void
    {
        $this->resultFilename = $resultFilename;
    }

    /**
     * @param float|null $waitTimeout
     */
    public function setWaitTimeout(?float $waitTimeout): void
    {
        $this->waitTimeout = $waitTimeout;
    }

    /**
     * @param string|null $webhookURL
     */
    public function setWebhookURL(?string $webhookURL): void
    {
        $this->webhookURL = $webhookURL;
    }
}
