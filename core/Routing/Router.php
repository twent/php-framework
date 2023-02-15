<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

use Twent\Framework\Http\HttpResponse;
use Twent\Framework\Routing\Contracts\RouteContract;
use Twent\Framework\Routing\Contracts\RouterContract;

final class Router implements RouterContract
{
    public function __construct(
        private array $routes = [],
        private readonly ResponseEmitter $emitter = new ResponseEmitter(),
    ) {
    }

    public function register(RouteContract|HttpResponse ...$routes): void
    {
        foreach ($routes as $route) {
            // Showing routes config errors
            if ($route instanceof HttpResponse) {
                $this->emitter->emit($route);
            }

            $this->routes[$route->getPath()] = $route;
        }
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function routeExists(string $path): bool
    {
        return array_key_exists($path, $this->routes);
    }

    public function getRoute(string $path): ?Route
    {
        if ($this->routeExists($path)) {
            return $this->routes[$path];
        }

        return null;
    }
}
