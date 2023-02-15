<?php

declare(strict_types=1);

namespace App\Http\Actions;

use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Http\HttpResponse;

final class HomeAction extends BaseAction
{
    public function __invoke(HttpRequest $request): HttpResponse
    {
        $name = $request->getQuery('name', 'World');

        return new HttpResponse(['data' => "This is Home Page. Hello, {$name}!"]);
    }
}
