<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

use function count;

abstract class ChromeRequest extends Request implements GotenbergRequestInterface
{
    private const WAIT_DELAY = 'waitDelay';
    private const PAPER_WIDTH = 'paperWidth';
    private const PAPER_HEIGHT = 'paperHeight';
    private const MARGIN_TOP = 'marginTop';
    private const MARGIN_BOTTOM  = 'marginBottom';
    private const MARGIN_LEFT = 'marginLeft';
    private const MARGIN_RIGHT = 'marginRight';
    private const LANDSCAPE = 'landscape';

    /** @var float|null */
    private $waitDelay;

    /** @var Document|null */
    private $header;

    /** @var Document|null */
    private $footer;

    /** @var float|null */
    private $paperWidth;

    /** @var float|null */
    private $paperHeight;

    /** @var float|null */
    private $marginTop;

    /** @var float|null */
    private $marginBottom;

    /** @var float|null */
    private $marginLeft;

    /** @var float|null */
    private $marginRight;

    /** @var bool */
    private $landscape;

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array
    {
        $values = parent::getFormValues();
        if ($this->waitDelay !== null) {
            $values[self::WAIT_DELAY] = $this->waitDelay;
        }
        if ($this->paperWidth !== null) {
            $values[self::PAPER_WIDTH] = $this->paperWidth;
        }
        if ($this->paperHeight !== null) {
            $values[self::PAPER_HEIGHT] = $this->paperHeight;
        }
        if ($this->marginTop !== null) {
            $values[self::MARGIN_TOP] = $this->marginTop;
        }
        if ($this->marginBottom !== null) {
            $values[self::MARGIN_BOTTOM] = $this->marginBottom;
        }
        if ($this->marginLeft !== null) {
            $values[self::MARGIN_LEFT] = $this->marginLeft;
        }
        if ($this->marginRight !== null) {
            $values[self::MARGIN_RIGHT] = $this->marginRight;
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
        if (! empty($this->header)) {
            $files['header.html'] = $this->header;
        }
        if (! empty($this->footer)) {
            $files['footer.html'] = $this->footer;
        }

        return $files;
    }

    public function setWaitDelay(?float $waitDelay): void
    {
        $this->waitDelay = $waitDelay;
    }

    /**
     * @param float[] $paperSize
     *
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
     *
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

    public function setHeader(?Document $header): void
    {
        $this->header = $header;
    }

    public function setFooter(?Document $footer): void
    {
        $this->footer = $footer;
    }

    public function setPaperWidth(?float $paperWidth): void
    {
        $this->paperWidth = $paperWidth;
    }

    public function setPaperHeight(?float $paperHeight): void
    {
        $this->paperHeight = $paperHeight;
    }

    public function setMarginTop(?float $marginTop): void
    {
        $this->marginTop = $marginTop;
    }

    public function setMarginBottom(?float $marginBottom): void
    {
        $this->marginBottom = $marginBottom;
    }

    public function setMarginLeft(?float $marginLeft): void
    {
        $this->marginLeft = $marginLeft;
    }

    public function setMarginRight(?float $marginRight): void
    {
        $this->marginRight = $marginRight;
    }

    public function setLandscape(bool $landscape): void
    {
        $this->landscape = $landscape;
    }
}
