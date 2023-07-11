<?php

declare(strict_types=1);

namespace Tests\Twent\Framework\Feature\DI;

final class Bar
{
    public function __construct(
        private Foo $foo
    ) {
    }
}
