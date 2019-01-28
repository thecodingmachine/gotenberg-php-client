<?php

namespace TheCodingMachine\Gotenberg;

final class OfficeRequest extends Request implements GotenbergRequestInterface
{
    /** @var Document[] */
    private $files;

    /** @var bool */
    private $landscape;

    /**
     * OfficeRequest constructor.
     * @param Document[] $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }


    /**
     * @return string
     */
    public function getPostURL(): string
    {
        return '/convert/office';
    }

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array
    {
        $values = [];
        if (!empty($this->webhookURL)) {
            $values[self::WEBHOOK_URL] = $this->webhookURL;
        }
        $values[self::LANDSCAPE] = $this->landscape;
        return $values;
    }

    /**
     * @return array<string,Document>
     */
    public function getFormFiles(): array
    {
        $files = [];
        foreach ($this->files as $file) {
            $files[$file->getFileName()] = $file;
        }
        return $files;
    }

    /**
     * @param bool $landscape
     */
    public function setLandscape(bool $landscape): void
    {
        $this->landscape = $landscape;
    }
}
