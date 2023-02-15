<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

use Closure;
use ReflectionClass;
use ReflectionException;
use Twent\Framework\Http\Enums\HttpMethod;
use Twent\Framework\Routing\Contracts\RouteConfigContract;

final class RouteConfig implements RouteConfigContract
{
    /**
     * @throws ReflectionException
     */
    public function __construct(
        private HttpMethod $method,
        private string $path,
        private string|Closure $handler,
        private ?string $name = null,
    ) {
        $this->path = mb_strtolower(rtrim($this->path, '/'));

        if (! str_starts_with($this->path, '/')) {
            $this->path = "/{$this->path}";
        }

        if (is_string($this->handler)) {
            $actionName = (new ReflectionClass($this->handler))->getShortName();
        }

        if (! $this->name) {
            if (! is_string($this->handler)) {
                $nameArray = array_filter(explode('/', $this->path), 'strlen');
            } else {
                $actionName = str_replace('Action', '', $actionName);
                $actionName = mb_strtolower(preg_replace('/[A-Z]/', ' $0', $actionName));
                $nameArray = array_filter(explode(' ', $actionName), 'strlen');
            }

            $this->name = implode('.', $nameArray);
        }
    }

    public function getMethod(): string
    {
        return $this->method->value;
    }

    public function setMethod(HttpMethod $method): RouteConfig
    {
        $this->method = $method;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): RouteConfig
    {
        $this->path = $path;
        return $this;
    }

    public function getHandler(): string|Closure
    {
        return $this->handler;
    }

    public function setHandler(string|Closure $handler): RouteConfig
    {
        $this->handler = $handler;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): RouteConfig
    {
        $this->name = $name;
        return $this;
    }
}
