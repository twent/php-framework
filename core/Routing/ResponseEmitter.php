<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

use Twent\Framework\Http\HttpResponse;

final class ResponseEmitter
{
    public function emit(HttpResponse $response): void
    {
        if (headers_sent() === false) {
            $this->emitHeaders($response);

            $this->emitStatusLine($response);
        }

        if (! $this->isResponseEmpty($response)) {
            $this->emitBody($response);
        }
    }

    public function isResponseEmpty(HttpResponse $response): bool
    {
        if (in_array($response->getStatusCode(), [204, 205, 304], true)) {
            return true;
        }

        if (mb_strlen($response->getBody()) === 0) {
            return true;
        }

        return false;
    }

    private function emitHeaders(HttpResponse $response): void
    {
        foreach ($response->getHeaders() as $title => $value) {
            $isReplaced = mb_strtolower($title) !== 'set-cookie';
            header("{$title}: {$value}", $isReplaced);
        }
    }

    private function emitStatusLine(HttpResponse $response): void
    {
        http_response_code($response->getStatusCode());
    }

    private function emitBody(HttpResponse $response): void
    {
        echo $response->getBody();
    }
}
