<?php

namespace TheCodingMachine\Gotenberg;

class URLRequest extends ChromeRequest
{
    /** @var string */
    protected $URL;

    /**
     * HTMLRequest constructor.
     * @param string $URL
     */
    public function __construct(string $URL)
    {
        $this->URL = $URL;
    }

    /**
     * @return string
     */
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
