<?php

namespace TheCodingMachine\Gotenberg;

interface GotenbergRequestInterface
{
    /**
     * @return string
     */
    public function getPostURL(): string;

    /**
     * @return array<string,mixed>
     */
    public function getFormValues(): array;

    /**
     * @return array<string,Document>
     */
    public function getFormFiles(): array;
}
