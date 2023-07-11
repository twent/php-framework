<?php

declare(strict_types=1);

namespace Tests\Twent\Framework\Feature\DI;

final class SingletonExample
{
    public static int $count = 0;

    public function __construct()
    {
        self::$count += 1;
    }
}
