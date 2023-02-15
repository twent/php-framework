<?php

declare(strict_types=1);

namespace Twent\Framework\Exceptions;

use Exception;
use Twent\Framework\Http\Enums\HttpStatus;

final class ActionNotFound extends Exception
{
    protected $message = 'Обработчик маршрута не найден!';

    public function __construct()
    {
        parent::__construct();
        $this->code = HttpStatus::InternalServerError->value;
    }
}
