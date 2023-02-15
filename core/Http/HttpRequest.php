<?php

declare(strict_types=1);

namespace Twent\Framework\Http;

use Twent\Framework\Http\Enums\HttpMethod;

final class HttpRequest
{
    private readonly array $body;

    private readonly string $path;
    private readonly array $query;
    private readonly array $cookies;
    private readonly ?array $headers;
    private readonly ?HttpMethod $method;
    private readonly array $files;

    public function __construct()
    {
        $this->body = $_POST;
        $this->path = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->query = $_GET;
        $this->cookies = $_COOKIE;
        $this->headers = getallheaders() ?: null;
        $this->method = HttpMethod::tryFrom($_SERVER['REQUEST_METHOD']);
        $this->files = $_FILES;
    }

    public function getQuery(?string $key = null, ?string $defaultValue = null): string|array|null
    {
        if (! $key && ! $defaultValue) {
            return $this->query;
        }

        if (array_key_exists($key, $this->query) && mb_strlen($this->query[$key])) {
            return $this->query[$key];
        }

        return $defaultValue;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getMethod(): ?string
    {
        return $this->method?->value;
    }

    public function hasHeader(string $header): bool
    {
        return array_key_exists($header, $this->headers);
    }

    public function hasCookie(string $cookie): bool
    {
        return array_key_exists($cookie, $this->cookies);
    }

    public function isAuthorised(): bool
    {
        if ($this->hasHeader('Authorization')) {
            return true;
        }

        return false;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFullPath(): string
    {
        return $_SERVER['HTTP_HOST'] . $this->getPath();
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}
