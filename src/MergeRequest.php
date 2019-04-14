<?php

namespace TheCodingMachine\Gotenberg;

final class MergeRequest extends Request implements GotenbergRequestInterface
{
    /** @var Document[] */
    private $files;

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
        return '/convert/merge';
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
