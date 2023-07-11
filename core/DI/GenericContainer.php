<?php

/**
 * @author Brent Rose (https://github.com/brendt)
 */

declare(strict_types=1);

namespace Twent\Framework\DI;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Twent\Framework\DI\Contracts\Container;

final class GenericContainer implements Container
{
    private array $definitions = [];
    private array $singletons = [];

    public function register(string $className, callable $definition): Container
    {
        $this->definitions[$className] = $definition;

        return $this;
    }

    public function singleton(string $className, callable $definition): Container
    {
        $this->definitions[$className] = function () use ($className, $definition) {
            $instance = $definition($this);
            $this->singletons[$className] = $instance;
            return $instance;
        };

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $className): object
    {
        if ($instance = ($this->singletons[$className] ?? null)) {
            return $instance;
        }

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
