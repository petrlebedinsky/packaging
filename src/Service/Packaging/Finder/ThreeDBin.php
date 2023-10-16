<?php

declare(strict_types=1);

namespace App\Service\Packaging\Finder;

use App\Entity\Packaging;
use App\Model\Product;
use App\Repository\PackagingRepository;
use App\Repository\ProductsSetRepository;
use App\Service\Packaging\ExactPackageFinder;
use App\Service\Packaging\FinderInterface;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\SerializerInterface;

class ThreeDBin implements FinderInterface
{
    public function __construct(
        private readonly Client $threeDBinClient,
        private readonly SerializerInterface $serializer,
        private readonly ProductsSetRepository $productsSetRepository,
        private readonly ExactPackageFinder $exactPackageFinder,
        private readonly PackagingRepository $packagingRepository,
        private readonly EntityManagerInterface $em,
        private readonly int $maxRetries = 0,
    )
    {
    }

    /**
     * @param Product[] $products
     */
    public function findPackaging(array $products): ?Packaging
    {
        //@TODO: convert products to appropriate request
        //@TODO: convert response to appropriate response dto
        $retry = 0;

        while ($retry <= $this->maxRetries) {
            try {
                $response = $this->threeDBinClient->request('POST', '/findBinSize', [
                    'json' => $this->serializer->serialize($products, 'json'),
                ]);

                if ($response->getStatusCode() === 200) {
                    //TODO: simplified - should be DTO object
                    //TODO: break method down
                    /** @var Packaging|null $packagingResponse */
                    $packagingResponse = $this->serializer->deserialize(
                        (string) $response->getBody(),
                        Packaging::class,
                        'json'
                    );

                    $packaging = $this->packagingRepository->find($packagingResponse->getId());
                    if ($packagingResponse !== null && $packaging === null) {
                        //TODO: create and persist packaging from packaging response
                    }

                    $productsSet = $this->productsSetRepository->find(
                        $this->exactPackageFinder->getProductsSetIdsKey($products),
                    );
                    if ($productsSet !== null) {
                        //TODO: create and persist products set with packaging attached
                    }

                    return $packagingResponse;
                }
                break;
            } catch (ClientException $e) {
                // wrong request, log and break without retry
                break;
            } catch (GuzzleException $e) {
                // network related error - try again if needed
            }
        }

        return null;
    }
}
