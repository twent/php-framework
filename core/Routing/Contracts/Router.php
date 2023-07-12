<?php

declare(strict_types=1);

namespace Twent\Framework\Routing\Contracts;

use Twent\Framework\Http\Contracts\Request;
use Twent\Framework\Http\Contracts\Response;

interface Router
{
    public function dispatch(Request $request): Response;
}
