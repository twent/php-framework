<?php

declare(strict_types=1);

namespace Twent\Framework\Http\Enums;

enum HttpMethod: string
{
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Patch = 'PATCH';
    case Delete = 'DELETE';
    case Head = 'HEAD';
    case Info = 'INFO';
    case Options = 'OPTIONS';
    case Trace = 'TRACE';
    case Connect = 'CONNECT';
}
