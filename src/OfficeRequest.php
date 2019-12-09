<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

final class OfficeRequest extends Request implements GotenbergRequestInterface
{
    private const LANDSCAPE = 'landscape';

    /** @var Document[] */
    private $files;

    /** @var bool */
    private $landscape;

    /**
     * @param Document[] $files
     */
    public function __construct(array $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function getPostURL(): string
    {
        return '/convert/office';
    }

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array
    {
        $values = parent::getFormValues();
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

    public function setLandscape(bool $landscape): void
    {
        $this->landscape = $landscape;
    }
}
