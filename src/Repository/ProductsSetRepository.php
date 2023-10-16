<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductsSet;
use Doctrine\ORM\EntityRepository;


/**
 * @method ProductsSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductsSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductsSet[]    findAll()
 * @method ProductsSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsSetRepository extends EntityRepository
{

}
