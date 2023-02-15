<?php

declare(strict_types=1);

namespace Twent\Framework\Http;

use JsonSerializable;
use Twent\Framework\Http\Enums\ContentType;
use Twent\Framework\Http\Enums\HttpStatus;

final class HttpResponse
{
    public function __construct(
        private string|array|JsonSerializable $body = '',
        private HttpStatus $status = HttpStatus::Ok,
        private ContentType $contentType = ContentType::ApplicationJson,
        private array $headers = [],
        private bool $isCached = true,
    ) {
        if ($this->contentType !== ContentType::TextHtml) {
            $this->changeContentType();
        }

        if (! $this->isCached) {
            $this->addNoCacheHeaders();
        }
    }

    public function getIsCached(): bool
    {
        return $this->isCached;
    }

    public function setIsCached(bool $isCached): HttpResponse
    {
        $this->isCached = $isCached;

        $this->addNoCacheHeaders();

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addHeader(string $title, string $value): HttpResponse
    {
        $this->headers[$title] = $value;

        return $this;
    }

    public function addNoCacheHeaders(): void
    {
        $this->addHeader('Cache-Control', 'no-cache, no-store, must-revalidate, no-transform');
    }

    public function getStatusCode(): int
    {
        return $this->status->value;
    }

    public function getContentType(): string
    {
        return $this->contentType->value;
    }

    public function getBody(): string|bool
    {
        if (is_array($this->body) || is_object($this->body)) {
            return json_encode($this->body, JSON_UNESCAPED_UNICODE);
        }

        return $this->body;
    }

    public function setContentType(ContentType $contentType): HttpResponse
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function setStatus(HttpStatus $status): HttpResponse
    {
        $this->status = $status;
        return $this;
    }

    public function setBody(array|string|JsonSerializable $body): HttpResponse
    {
        $this->body = $body;
        return $this;
    }

    private function changeContentType(): void
    {
        $this->addHeader('Content-Type', $this->getContentType());
    }
}
