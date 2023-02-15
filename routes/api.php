<?php

declare(strict_types=1);

use App\Http\Actions\ByeAction;
use App\Http\Actions\HelloAction;
use App\Http\Actions\HomeAction;
use Twent\Framework\Http\HttpRequest;
use Twent\Framework\Http\HttpResponse;
use Twent\Framework\Routing\Route;
use Twent\Framework\Routing\Router;

$router = new Router();

$router->register(
    Route::get('/', HomeAction::class, 'home'),
    Route::get('/hello', HelloAction::class, 'hello'),
    Route::get('/bye', ByeAction::class, 'bye'),
    Route::get('/callback', static function (HttpRequest $request) {
        return new HttpResponse(['result' => "callback test {$request->getFullPath()}"]);
    }),
);

return $router;
