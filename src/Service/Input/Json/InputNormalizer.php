<?php

declare(strict_types=1);

namespace App\Service\Input\Json;

use App\Model\Product;
use App\Service\Error\Exception\ValidationException;
use App\Service\Input\InputNormalizerInterface;
use JsonException;

class InputNormalizer implements InputNormalizerInterface
{
    public function normalize(mixed $input): array
    {
        try {
            $productsInput = json_decode($input, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ValidationException([$e->getMessage()]);
        }

        $products = [];

        foreach($productsInput as $productInput) {
            $products[] = new Product(
                $productInput['id'],
                $productInput['width'],
                $productInput['height'],
                $productInput['length'],
                $productInput['weight']
            );
        }

        return $products;
    }
}
