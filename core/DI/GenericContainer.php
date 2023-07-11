<?php

declare(strict_types=1);

namespace Twent\Framework\DI;

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
        $definition = $this->definitions[$className];

        return $definition();
    }
}
