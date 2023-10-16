<?php

declare(strict_types=1);

namespace App\Service\Validator;

use App\Model\Product;
use App\Service\Error\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class Validator
{
    public function __construct(private ValidatorInterface $validator)
    {
    }


    /**
     * @param Product[] $products
     */
    public function validateProducts(array $products): void
    {
        $errors = [];
        foreach($products as $product) {
            $productErrors = $this->validator->validate($product);
            if (count($productErrors) !== 0) {
                foreach ($productErrors as $productError) {
                    $errors[] = $productError->getMessage();
                }
            }
        }

        if (count($errors) !== 0) {
            throw new ValidationException($errors);
        }
    }
}
