<?php

declare(strict_types=1);

namespace Twent\Framework\Http\Contracts;

use Twent\Framework\Http\Enums\HttpStatus;

interface Response
{
    public function getStatus(): HttpStatus;
    public function getBody(): string;
}
