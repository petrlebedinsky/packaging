<?php

declare(strict_types=1);

namespace App\Service\Packaging;

use App\Entity\Packaging;
use App\Model\Product;

class Calculator
{
    /**
     * @param FinderInterface[] $packagingFinders
     */
    public function __construct(
        private readonly ExactPackageFinder $exactPackageFinder,
        private readonly FinderInterface $fallbackFinder,
        private array $packagingFinders,
    )
    {
    }

    /**
     * @param Product[] $products
     */
    public function findPackaging(array $products): ?Packaging
    {
        $packaging = $this->exactPackageFinder->getPackageForProducts($products);
        if ($packaging !== null) {
            return $packaging;
        }

        foreach($this->packagingFinders as $finder) {
            $packaging = $finder->findPackaging($products);
            if ($packaging !== null) {
                return $packaging;
            }
        }

        return $this->fallbackFinder->findPackaging($products);
    }

    public function addPackagingFinder(FinderInterface $finder): void
    {
        $this->packagingFinders[] = $finder;
    }
}
