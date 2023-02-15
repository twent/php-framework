<?php

declare(strict_types=1);

namespace Twent\Framework\Routing\Contracts;

interface RouterContract
{
    public function register(RouteContract ...$routes): void;
    public function getRoutes(): array;
    public function routeExists(string $path): bool;
    public function getRoute(string $path): ?RouteContract;
}
