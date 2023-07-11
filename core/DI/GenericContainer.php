<?php

declare(strict_types=1);

namespace Twent\Framework\DI;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Twent\Framework\DI\Contracts\Container;

final class GenericContainer implements Container
{
    private array $definitions = [];

    public function register(string $className, callable $definition): Container
    {
        $this->definitions[$className] = $definition;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $className): object
    {
        $definition = $this->definitions[$className] ?? $this->autowire(...);

        return $definition($className);
    }

    /**
     * @throws ReflectionException
     */
    private function autowire(string $className): object
    {
        $reflection = new ReflectionClass($className);

        $parameters = array_map(
            fn(ReflectionParameter $param) => $this->get($param->getType()->getName()),
            $reflection->getConstructor()?->getParameters() ?? []
        );

        return new $className(...$parameters);
    }
}
