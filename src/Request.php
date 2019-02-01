<?php

namespace TheCodingMachine\Gotenberg;

abstract class Request
{
    public const A3 = [11.7, 16.5];
    public const A4 = [8.27, 11.7];
    public const A5 = [5.8, 8.2];
    public const A6 = [4.1, 5.8];
    public const LETTER = [8.5, 11];
    public const LEGAL = [8.5, 14];
    public const TABLOID = [11, 17];

    public const NO_MARGINS = [0, 0, 0, 0];
    public const NORMAL_MARGINS = [1, 1, 1, 1];
    public const LARGE_MARGINS = [2, 2, 2, 2];

    protected const REMOTE_URL = 'remoteURL';
    protected const WEBHOOK_URL = 'webhookURL';
    protected const PAPER_WIDTH = 'paperWidth';
    protected const PAPER_HEIGHT = 'paperHeight';
    protected const MARGIN_TOP = 'marginTop';
    protected const MARGIN_BOTTOM  = 'marginBottom';
    protected const MARGIN_LEFT = 'marginLeft';
    protected const MARGIN_RIGHT = 'marginRight';
    protected const LANDSCAPE = 'landscape';
    protected const WEB_FONTS_TIMEOUT = 'webFontsTimeout';

    /** @var string|null */
    protected $webhookURL;

    /**
     * @param string|null $webhookURL
     */
    public function setWebhookURL(?string $webhookURL): void
    {
        $this->webhookURL = $webhookURL;
    }
}
