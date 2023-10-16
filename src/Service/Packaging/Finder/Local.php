<?php

declare(strict_types=1);

namespace App\Service\Packaging\Finder;

use App\Entity\Packaging;
use App\Model\Product;
use App\Repository\PackagingRepository;
use App\Service\Packaging\FinderInterface;

class Local implements FinderInterface
{
    public function __construct(private readonly PackagingRepository $packagingRepository)
    {
    }

    /**
     * @param Product[] $products
     */
    public function findPackaging(array $products): ?Packaging
    {
        //@TODO: try to fetch from db
    }
}
