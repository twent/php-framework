<?php

declare(strict_types=1);

namespace Twent\Framework\Http;

use Attribute;
use Twent\Framework\Http\Enums\HttpMethod;

#[Attribute]
final readonly class Post extends Route
{
    public function __construct(string $uri)
    {
        parent::__construct($uri, HttpMethod::Post);
    }
}
