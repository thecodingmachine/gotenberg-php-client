<?php

namespace TheCodingMachine\Gotenberg;

abstract class ChromeRequest extends Request implements GotenbergRequestInterface
{
    /** @var Document|null */
    protected $header;

    /** @var Document|null */
    protected $footer;

    /** @var float|null */
    protected $paperWidth;

    /** @var float|null */
    protected $paperHeight;

    /** @var float|null */
    protected $marginTop;

    /** @var float|null */
    protected $marginBottom;

    /** @var float|null */
    protected $marginLeft;

    /** @var float|null */
    protected $marginRight;

    /** @var bool */
    protected $landscape;

    /** @var int|null */
    protected $webFontsTimeout;

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
        if (!is_null($this->marginTop)) {
            $values[self::MARGIN_TOP] = $this->marginTop;
        }
        if (!is_null($this->marginBottom)) {
            $values[self::MARGIN_BOTTOM] = $this->marginBottom;
        }
        if (!is_null($this->marginLeft)) {
            $values[self::MARGIN_LEFT] = $this->marginLeft;
        }
        if (!is_null($this->marginRight)) {
            $values[self::MARGIN_RIGHT] = $this->marginRight;
        }
        if (!is_null($this->webFontsTimeout)) {
            $values[self::WEB_FONTS_TIMEOUT] = $this->webFontsTimeout;
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
        if (!empty($this->header)) {
            $files['header.html'] = $this->header;
        }
        if (!empty($this->footer)) {
            $files['footer.html'] = $this->footer;
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
     * @param Document|null $header
     */
    public function setHeader(?Document $header): void
    {
        $this->header = $header;
    }

    /**
     * @param Document|null $footer
     */
    public function setFooter(?Document $footer): void
    {
        $this->footer = $footer;
    }

    /**
     * @param float|null $paperWidth
     */
    public function setPaperWidth(?float $paperWidth): void
    {
        $this->paperWidth = $paperWidth;
    }

    /**
     * @param float|null $paperHeight
     */
    public function setPaperHeight(?float $paperHeight): void
    {
        $this->paperHeight = $paperHeight;
    }

    /**
     * @param float|null $marginTop
     */
    public function setMarginTop(?float $marginTop): void
    {
        $this->marginTop = $marginTop;
    }

    /**
     * @param float|null $marginBottom
     */
    public function setMarginBottom(?float $marginBottom): void
    {
        $this->marginBottom = $marginBottom;
    }

    /**
     * @param float|null $marginLeft
     */
    public function setMarginLeft(?float $marginLeft): void
    {
        $this->marginLeft = $marginLeft;
    }

    /**
     * @param float|null $marginRight
     */
    public function setMarginRight(?float $marginRight): void
    {
        $this->marginRight = $marginRight;
    }

    /**
     * @param bool $landscape
     */
    public function setLandscape(bool $landscape): void
    {
        $this->landscape = $landscape;
    }

    /**
     * @param int|null $webFontsTimeout
     */
    public function setWebFontsTimeout(?int $webFontsTimeout): void
    {
        $this->webFontsTimeout = $webFontsTimeout;
    }
}
