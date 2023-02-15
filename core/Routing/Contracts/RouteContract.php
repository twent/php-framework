<?php

declare(strict_types=1);

namespace Twent\Framework\Routing\Contracts;

use Closure;
use Stringable;
use Twent\Framework\Http\Enums\HttpMethod;
use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Http\HttpResponse;

interface RouteContract extends Stringable
{
    public static function create(
        HttpMethod $method,
        string $path,
        string|Closure $handler,
        ?string $name = null,
    ): RouteContract|HttpResponse;

    public static function get(
        string $path,
        string|Closure $handler,
        ?string $name = null,
    ): RouteContract|HttpResponse;

    public static function post(
        string $path,
        string|Closure $handler,
        ?string $name = null,
    ): RouteContract|HttpResponse;

    public function getRequest(): ?HttpRequest;

    public function getMethod(): string;

    public function setMethod(HttpMethod $method): RouteContract;

    public function getPath(): string;

    public function setPath(string $path): RouteContract;

    public function getHandler(): RequestHandlerContract|Closure;

    public function setHandler(string|Closure $handler): RouteContract;

    public function getName(): string;

    public function setName(string $name): RouteContract;
}
