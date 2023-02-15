<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

use Twent\Framework\Http\Exceptions\PageNotFound;
use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Routing\Contracts\RouteMatcherContract;

final class RouteMatcher implements RouteMatcherContract
{
    public function __construct(
        private readonly Router $router,
    ) {
    }

    /**
     * @throws PageNotFound
     */
    public function match(HttpRequest $request): Route
    {
        if (! $this->router->routeExists($request->getPath())) {
            throw new PageNotFound();
        }

        return $this->router->getRoute($request->getPath());
    }
}
