<?php

declare(strict_types=1);

namespace Twent\Framework\Http;

use Twent\Framework\Http\Enums\HttpStatus;

final readonly class GenericResponse implements Contracts\Response
{
    public function __construct(
        private HttpStatus $status,
        private string $body,
    ) {
    }

    public function getStatus(): HttpStatus
    {
        return $this->status;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
