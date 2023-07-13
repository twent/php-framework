<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Twent\Framework\DI\Contracts\Container;
use Twent\Framework\Http\Contracts\Request;
use Twent\Framework\Http\Contracts\Response;
use Twent\Framework\Http\Enums\HttpStatus;
use Twent\Framework\Http\GenericResponse;
use Twent\Framework\Http\Route as RouteAttribute;

final readonly class GenericRouter implements Contracts\Router
{
    public function __construct(
        private Container $container,
        private RouterConfig $config,
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function dispatch(Request $request): Response
    {
        foreach ($this->config->controllers as $controllerClass) {
            $reflectionClass = new ReflectionClass($controllerClass);

            foreach ($reflectionClass->getMethods() as $method) {
                $routeAttribute = $method->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

                if (! $routeAttribute) {
                    continue;
                }

                /** @var RouteAttribute $route */
                $route = $routeAttribute->newInstance();

                if ($route->method !== $request->getMethod()) {
                    continue;
                }

                $params = $this->resolveParams($route->uri, $request->getUri());
                $controller = $this->container->get($controllerClass);

                if ($params === null && ($route->uri === $request->getUri())) {
                    return $controller->{$method->getName()}();
                }

                if ($params !== null) {
                    return $controller->{$method->getName()}(...$params);
                }
            }
        }

        return new GenericResponse(HttpStatus::NotFound);
    }

    private function resolveParams(string $routeUri, string $requestUri): ?array
    {
        $result = preg_match_all('/\{\w+}/', $routeUri, $tokens);

        if (! $result) {
            return null;
        }

        $tokens = $tokens[0];

        $matchingRegex = '/^' . str_replace(
            ['/', ...$tokens],
            ['\\/', ...array_fill(0, count($tokens), '([\w\d\s)]+)')],
            $routeUri
        ) . '$/';

        $result = preg_match_all($matchingRegex, $requestUri, $matches);

        if ($result === 0) {
            return null;
        }

        unset($matches[0]);

        $matches = array_values($matches);

        $valueMap = [];

        foreach ($matches as $i => $match) {
            $valueMap[trim($tokens[$i], '{}')] = $match[0];
        }

        return $valueMap;
    }
}
