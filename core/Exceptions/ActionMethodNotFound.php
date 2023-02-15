<?php

declare(strict_types=1);

namespace Twent\Framework\Exceptions;

use Exception;
use Twent\Framework\Http\Enums\HttpStatus;

final class ActionMethodNotFound extends Exception
{
    protected $message = 'Метод обработчика маршрута не найден!';

    public function __construct()
    {
        parent::__construct();
        $this->code = HttpStatus::InternalServerError->value;
    }
}
