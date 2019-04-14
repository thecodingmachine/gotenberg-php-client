<?php

namespace TheCodingMachine\Gotenberg;

class HTMLRequest extends ChromeRequest implements GotenbergRequestInterface
{
    /** @var Document */
    private $index;

    /** @var Document[] */
    private $assets;

    /**
     * HTMLRequest constructor.
     * @param Document $index
     */
    public function __construct(Document $index)
    {
        $this->index = $index;
        $this->assets = [];
    }

    /**
     * @return string
     */
    public function getPostURL(): string
    {
        return '/convert/html';
    }

    /**
     * @return array<string,Document>
     */
    public function getFormFiles(): array
    {
        $files = parent::getFormFiles();
        $files['index.html'] = $this->index;
        foreach ($this->assets as $asset) {
            $files[$asset->getFileName()] = $asset;
        }
        return $files;
    }

    /**
     * @param Document[] $assets
     */
    public function setAssets(array $assets): void
    {
        $this->assets = $assets;
    }
}
