<?php

declare(strict_types=1);

namespace Twent\Framework\Http;

use Attribute;
use Twent\Framework\Http\Enums\HttpMethod;

#[Attribute]
readonly class Route
{
    public function __construct(
        public string $uri,
        public HttpMethod $method,
    ) {
    }
}
