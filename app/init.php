<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Twent\Framework\App;

$router = include __DIR__ . '/../routes/api.php';

$app = new App($router);

$app->run();
