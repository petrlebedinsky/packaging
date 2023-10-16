<?php

declare(strict_types=1);

namespace App\Service\Error;

enum ErrorCodeEnum: string
{
    case INTERNAL_ERROR = 'INTERNAL_ERROR';
    case VALIDATION_ERROR = 'VALIDATION_ERROR';
}
