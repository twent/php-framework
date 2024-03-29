<?php

declare(strict_types=1);

namespace Tests\Twent\Framework\Feature\DI;

use PHPUnit\Framework\TestCase;
use Twent\Framework\DI\GenericContainer;

final class GenericContainerTest extends TestCase
{
    public function testContainer(): void
    {
        $container = new GenericContainer();

        $container->register(Foo::class, static fn() => new Foo());

        $foo = $container->get(Foo::class);

        $this->assertInstanceOf(Foo::class, $foo);
    }

    public function testContainerAutowire(): void
    {
        $container = new GenericContainer();

        $bar = $container->get(Bar::class);

        $this->assertInstanceOf(Bar::class, $bar);
    }

    public function testSingleton(): void
    {
        $container = new GenericContainer();

        $container->singleton(SingletonExample::class, fn() => new SingletonExample());
        $instance = $container->get(SingletonExample::class);

        $this->assertInstanceOf(SingletonExample::class, $instance);
        $this->assertEquals(1, $instance::$count);

        $this->assertInstanceOf(SingletonExample::class, $instance);
        $this->assertEquals(1, $instance::$count);
    }
}
