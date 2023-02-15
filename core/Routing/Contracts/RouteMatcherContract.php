<?php

declare(strict_types=1);

namespace Twent\Framework\Routing\Contracts;

use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Routing\Route;

interface RouteMatcherContract
{
    public function match(HttpRequest $request): Route;
}
