<?php

declare(strict_types=1);

namespace App\Service\Error;

use App\Service\Error\Exception\ValidationException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ErrorHandler
{
    public function handleError(Throwable $e): ResponseInterface
    {
        if ($e instanceof ValidationException) {
            return new Response($e->getCode(), [], json_encode([
                'code' => ErrorCodeEnum::VALIDATION_ERROR,
                'message' => $e->getValidationsAsString(),
            ]));
        }

        //@TODO: body based on env PROD/DEV
        return new Response(500, [], json_encode([
            'code' => ErrorCodeEnum::INTERNAL_ERROR,
            'message' => $e->getMessage(),
        ]));
    }
}
