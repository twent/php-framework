<?php

declare(strict_types=1);

namespace Twent\Framework\Http;

use Twent\Framework\Http\Enums\HttpMethod;

final readonly class GenericRequest implements Contracts\Request
{
    public function __construct(
        private HttpMethod $method,
        private string $uri,
        private array $body = [],
    ) {
    }

    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
