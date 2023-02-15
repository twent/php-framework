<?php

declare(strict_types=1);

namespace Twent\Framework\Routing\Contracts;

use Closure;
use Twent\Framework\Http\Enums\HttpMethod;

interface RouteConfigContract
{
    public function getMethod(): string;
    public function setMethod(HttpMethod $method): RouteConfigContract;
    public function getPath(): string;
    public function setPath(string $path): RouteConfigContract;
    public function getHandler(): string|Closure;
    public function setHandler(string|Closure $handler): RouteConfigContract;
    public function getName(): string;
    public function setName(string $name): RouteConfigContract;
}
