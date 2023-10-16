<?php

declare(strict_types=1);

namespace App\Service\Packaging;

use App\Entity\Packaging;
use App\Model\Product;
use App\Repository\ProductsSetRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class ExactPackageFinder
{
    public function __construct(
        private CacheInterface $cache,
        private ProductsSetRepository $productsSetRepository,
    )
    {
    }
    public function getPackageForProducts(array $products): ?Packaging
    {
        $cacheKey = $this->createPackagingCacheKey($products);
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($cacheKey) {
            $productsSet = $this->productsSetRepository->find($cacheKey);
            return $productsSet?->getPackaging();
        });
    }

    /**
     * @param Product[] $products
     */
    //@TODO: move outside class ?
    public function createPackagingCacheKey(array $products): string
    {
        $ids = $this->getProductsSetIdsKey($products);
        return sprintf('prod_pack_ids_%s', implode('_', $ids));
    }

    /**
     * @param Product[] $products
     */
    public function getProductsSetIdsKey(array $products): array
    {
        $ids = [];
        foreach ($products as $product) {
            $ids[] = $product->getId();
        }
        rsort($ids);
        return $ids;
    }
}
