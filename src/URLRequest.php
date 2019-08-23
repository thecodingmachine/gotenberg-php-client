<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

final class URLRequest extends ChromeRequest implements GotenbergRequestInterface
{
    private const REMOTE_URL = 'remoteURL';

    /** @var string */
    private $URL;

    public function __construct(string $URL)
    {
        $this->URL = $URL;
    }

    public function getPostURL(): string
    {
        return '/convert/url';
    }

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array
    {
        $values = parent::getFormValues();
        $values[self::REMOTE_URL] = $this->URL;

        return $values;
    }
}
