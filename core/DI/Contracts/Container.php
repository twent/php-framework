<?php

declare(strict_types=1);

namespace Twent\Framework\DI\Contracts;

interface Container
{
    public function register(string $className, callable $definition): self;

    /**
     * @template TClassName
     * @param class-string<TClassName> $className
     * @return TClassName
     */
    public function get(string $className): object;
}
