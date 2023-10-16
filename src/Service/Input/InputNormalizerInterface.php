<?php

declare(strict_types=1);

namespace App\Service\Input;

use App\Model\Product;

interface InputNormalizerInterface
{
    /**
     * @return Product[]
     */
    public function normalize(mixed $input): array;
}
