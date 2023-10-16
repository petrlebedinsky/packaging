<?php

declare(strict_types=1);

namespace App\Service\Packaging;

use App\Entity\Packaging;
use App\Model\Product;

interface FinderInterface
{
    /**
     * @param Product[] $products
     */
    public function findPackaging(array $products): ?Packaging;
}
