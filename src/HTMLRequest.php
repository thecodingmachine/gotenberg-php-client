<?php

namespace TheCodingMachine\Gotenberg;

class HTMLRequest extends ChromeRequest
{
    /** @var Document */
    protected $index;

    /** @var Document[] */
    protected $assets;

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
     * @param float[] $margins
     * @throws RequestException
     */
    public function setMargins(array $margins): void
    {
        if (count($margins) !== 4) {
            throw new RequestException('Wrong margins.');
        }
        $this->marginTop = $margins[0];
        $this->marginBottom = $margins[1];
        $this->marginLeft = $margins[2];
        $this->marginRight = $margins[3];
    }

    /**
     * @param Document[] $assets
     */
    public function setAssets(array $assets): void
    {
        $this->assets = $assets;
    }
}
