<?php

declare(strict_types=1);

namespace Twent\Framework\Http\Exceptions;

use Exception;
use Twent\Framework\Http\Enums\HttpStatus;

final class PageNotFound extends Exception
{
    protected $message = 'Страница не найдена!';

    public function __construct()
    {
        parent::__construct();
        $this->code = HttpStatus::NotFound->value;
    }
}
