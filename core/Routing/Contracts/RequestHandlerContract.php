<?php

declare(strict_types=1);

namespace Twent\Framework\Routing\Contracts;

use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Http\HttpResponse;

interface RequestHandlerContract
{
    public function __invoke(HttpRequest $request): HttpResponse;
}
