<?php

declare(strict_types=1);

namespace TheCodingMachine\Gotenberg;

interface GotenbergRequestInterface
{
    public function getPostURL(): string;

    /**
     * @return array<string,string>
     */
    public function getCustomHTTPHeaders(): array;

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array;

    /**
     * @return array<string,Document>
     */
    public function getFormFiles(): array;

    public function hasWebhook(): bool;
}
