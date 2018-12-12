<?php

namespace TheCodingMachine\Gotenberg;

final class OfficeRequest extends Request implements GotenbergRequestInterface
{
    /** @var Document[] */
    private $files;

    /** @var float|null */
    private $paperWidth;

    /** @var float|null */
    private $paperHeight;

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
        if (!is_null($this->paperWidth)) {
            $values[self::PAPER_WIDTH] = $this->paperWidth;
        }
        if (!is_null($this->paperHeight)) {
            $values[self::PAPER_HEIGHT] = $this->paperHeight;
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
     * @param float[] $paperSize
     * @throws RequestException
     */
    public function setPaperSize(array $paperSize): void
    {
        if (count($paperSize) !== 2) {
            throw new RequestException('Wrong paper size.');
        }
        $this->paperWidth = $paperSize[0];
        $this->paperHeight = $paperSize[1];
    }

    /**
     * @param bool $landscape
     */
    public function setLandscape(bool $landscape): void
    {
        $this->landscape = $landscape;
    }
}
