<?php

declare(strict_types=1);

namespace Tests\Twent\Framework\Feature;

use Tests\Twent\Framework\TestCase;
use Twent\Framework\Http\Enums\HttpMethod;
use Twent\Framework\Http\Enums\HttpStatus;
use Twent\Framework\Http\GenericRequest;
use Twent\Framework\Routing\Contracts\Router;

final class GenericRouterTest extends TestCase
{
    public function testRouter(): void
    {
        /** @var Router $router */
        $router = $this->container->get(Router::class);

        $response = $router->dispatch(
            new GenericRequest(HttpMethod::Get, '/home')
        );

        $this->assertSame(HttpStatus::Ok, $response->getStatus());
        $this->assertSame('Home', $response->getBody());
    }
}