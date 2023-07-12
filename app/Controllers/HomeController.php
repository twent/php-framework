<?php

declare(strict_types=1);

namespace App\Controllers;

use Twent\Framework\Http\Contracts\Response;
use Twent\Framework\Http\Enums\HttpStatus;
use Twent\Framework\Http\GenericResponse;
use Twent\Framework\Http\Get;

final readonly class HomeController
{
    #[Get(uri: '/home')]
    public function index(): Response
    {
        return new GenericResponse(HttpStatus::Ok, 'Home');
    }
}
