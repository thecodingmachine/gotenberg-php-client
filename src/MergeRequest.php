<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

final class MergeRequest extends Request implements GotenbergRequestInterface
{
    /** @var Document[] */
    private $files;

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
        return '/merge';
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
}
