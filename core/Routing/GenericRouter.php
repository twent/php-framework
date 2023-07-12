<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Twent\Framework\DI\Contracts\Container;
use Twent\Framework\Http\Contracts\Request;
use Twent\Framework\Http\Contracts\Response;
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

                if ($route->uri !== $request->getUri()) {
                    continue;
                }

                $controller = $this->container->get($controllerClass);

                return $controller->{$method->getName()}();
            }
        }
    }
}
