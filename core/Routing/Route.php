<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

use Closure;
use Exception;
use ReflectionException;
use Twent\Framework\Exceptions\ActionMethodNotFound;
use Twent\Framework\Exceptions\ActionNotFound;
use Twent\Framework\Http\Enums\HttpMethod;
use Twent\Framework\Http\Enums\HttpStatus;
use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Http\HttpResponse;
use Twent\Framework\Routing\Contracts\RequestHandlerContract;
use Twent\Framework\Routing\Contracts\RouteContract;

final class Route implements RouteContract
{
    public function __construct(
        private RouteConfig $config,
    ) {
    }

    public function __toString(): string
    {
        return $this->config->getMethod() . ' | '
            . $this->config->getPath() . ' | '
            . $this->config->getHandler() . ' | '
            . $this->config->getName();
    }

    public static function create(
        HttpMethod $method,
        string $path,
        string|Closure $handler,
        ?string $name = null,
    ): Route|HttpResponse {
        try {
            $config = new RouteConfig($method, $path, $handler, $name);
        } catch (ReflectionException $e) {
            return self::routeCreationError($e);
        }

        return new Route($config);
    }

    public static function get(
        string $path,
        string|Closure $handler,
        ?string $name = null,
    ): Route|HttpResponse {
        //dd($handler, $name);
        try {
            $config = new RouteConfig(HttpMethod::Get, $path, $handler, $name);
        } catch (Exception $e) {
            return self::routeCreationError($e);
        }

        return new Route($config);
    }

    public static function post(
        string $path,
        string|Closure $handler,
        ?string $name = null,
    ): Route|HttpResponse {
        try {
            $config = new RouteConfig(HttpMethod::Post, $path, $handler, $name);
        } catch (ReflectionException $e) {
            return self::routeCreationError($e);
        }

        return new Route($config);
    }

    public function getRequest(): ?HttpRequest
    {
        return null;
    }

    public function getMethod(): string
    {
        return $this->config->getMethod();
    }

    public function setMethod(HttpMethod $method): Route
    {
        $this->config->setMethod($method);
        return $this;
    }

    public function getPath(): string
    {
        return $this->config->getPath();
    }

    public function setPath(string $path): Route
    {
        $this->config->setPath($path);
        return $this;
    }

    /**
     * @throws ActionMethodNotFound
     * @throws ActionNotFound
     */
    public function getHandler(): RequestHandlerContract|Closure
    {
        if (is_callable($this->config->getHandler())) {
            return $this->config->getHandler();
        }

        $className = $this->config->getHandler();

        if (! class_exists($className)) {
            throw new ActionNotFound();
        }

        $handler = new $className();

        if (! method_exists($handler, '__invoke')) {
            throw new ActionMethodNotFound();
        }

        return $handler;
    }

    public function setHandler(string|Closure $handler): Route
    {
        $this->config->setHandler($handler);
        return $this;
    }

    public function getName(): string
    {
        return $this->config->getName();
    }

    public function setName(string $name): Route
    {
        $this->config->setName($name);
        return $this;
    }

    private static function routeCreationError(Exception $e): HttpResponse
    {
        return new HttpResponse(
            'Ошибка создания маршрута: ' . $e->getMessage(),
            HttpStatus::InternalServerError
        );
    }
}
