<?php

namespace App;

use App\Service\Error\ErrorHandler;
use App\Service\Packaging\Calculator;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Application
{
    public function __construct(
        private readonly Calculator $calculator,
        private readonly ErrorHandler $errorHandler,
    ) {
    }

    public function run(RequestInterface $request): ResponseInterface
    {
        try {
            $box = $this->calculator->findPackaging();
            return new Response(200, [], json_encode([
                'width' => $box->getWidth(),
                'height' => $box->getHeight(),
                'length' => $box->getLength(),
            ], JSON_THROW_ON_ERROR));
        } catch (Throwable $e) {
            return $this->errorHandler->handleError($e);
        }
    }

}
