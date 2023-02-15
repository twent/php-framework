<?php

declare(strict_types=1);

namespace Twent\Framework;

use Exception;
use Twent\Framework\Http\Enums\HttpStatus;
use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Http\HttpResponse;
use Twent\Framework\Routing\ResponseEmitter;
use Twent\Framework\Routing\RouteMatcher;
use Twent\Framework\Routing\Router;

final class App
{
    private readonly RouteMatcher $matcher;
    private readonly ResponseEmitter $emitter;
    public function __construct(
        private readonly Router $router,
    ) {
        $this->matcher = new RouteMatcher($this->router);
        $this->emitter = new ResponseEmitter();
    }

    public function run(): void
    {
        $request = new HttpRequest();

        try {
            $route = $this->matcher->match($request);
            $handler = $route->getHandler();
            $response = $handler($request);
        } catch (Exception $e) {
            $response = new HttpResponse(['error' => $e->getMessage()], HttpStatus::tryFrom($e->getCode()));
        }

        $this->emitter->emit($response);
    }
}
