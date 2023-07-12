<?php

declare(strict_types=1);

namespace Tests\Twent\Framework;

use App\Controllers\HomeController;
use Twent\Framework\DI\Contracts\Container;
use Twent\Framework\DI\GenericContainer;
use Twent\Framework\Routing\Contracts\Router;
use Twent\Framework\Routing\GenericRouter;
use Twent\Framework\Routing\RouterConfig;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected GenericContainer $container;

    protected function setUp(): void
    {
        $this->container = new GenericContainer();

        $this->container->singleton(Container::class, fn() => $this->container);

        $this->container->singleton(
            Router::class,
            fn(Container $container) => $container->get(GenericRouter::class),
        );

        $this->container->singleton(
            RouterConfig::class,
            fn() => new RouterConfig(
                controllers: [
                    HomeController::class,
                ]
            ),
        );
    }
}
