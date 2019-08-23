<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

final class MarkdownRequest extends HTMLRequest implements GotenbergRequestInterface
{
    /** @var Document[] */
    private $markdowns;

    /**
     * @param Document[] $markdowns
     */
    public function __construct(Document $index, array $markdowns)
    {
        parent::__construct($index);
        $this->markdowns = $markdowns;
    }

    public function getPostURL(): string
    {
        return '/convert/markdown';
    }

    /**
     * @return array<string,Document>
     */
    public function getFormFiles(): array
    {
        $files = parent::getFormFiles();
        foreach ($this->markdowns as $markdown) {
            $files[$markdown->getFileName()] = $markdown;
        }

        return $files;
    }
}
