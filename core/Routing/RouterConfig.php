<?php

declare(strict_types=1);

namespace Twent\Framework\Routing;

final readonly class RouterConfig
{
    public function __construct(
        public array $controllers = [],
    ) {
    }
}
