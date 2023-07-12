<?php

declare(strict_types=1);

namespace Twent\Framework\Http\Contracts;

use Twent\Framework\Http\Enums\HttpMethod;

interface Request
{
    public function getMethod(): HttpMethod;
    public function getUri(): string;
    public function getBody(): array;
}
