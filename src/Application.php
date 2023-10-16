<?php

namespace App;

use App\Service\Error\ErrorHandler;
use App\Service\Input\InputNormalizerInterface;
use App\Service\Packaging\Calculator;
use App\Service\Validator\Validator;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

readonly class Application
{
    public function __construct(
        private Calculator $calculator,
        private ErrorHandler $errorHandler,
        private InputNormalizerInterface $inputNormalizer,
        private Validator $validator,
    ) {
    }

    //@TODO: Logging
    //@TODO: Symfony container
    //@TODO: Async api calls
    public function run(RequestInterface $request): ResponseInterface
    {
        try {
            //@TODO: Move glue code outside of app
            $products = $this->inputNormalizer->normalize($request->getBody());
            $this->validator->validateProducts($products);
            $packaging = $this->calculator->findPackaging($products);

            if ($packaging === null) {
                return new Response(404);
            }

            return new Response(200, [], json_encode([
                'width' => $packaging->getWidth(),
                'height' => $packaging->getHeight(),
                'length' => $packaging->getLength(),
            ], JSON_THROW_ON_ERROR));
        } catch (Throwable $e) {
            return $this->errorHandler->handleError($e);
        }
    }

}
