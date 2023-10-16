<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Packaging;
use Doctrine\ORM\EntityRepository;

/**
 * @method Packaging|null find($id, $lockMode = null, $lockVersion = null)
 * @method Packaging|null findOneBy(array $criteria, array $orderBy = null)
 * @method Packaging[]    findAll()
 * @method Packaging[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackagingRepository extends EntityRepository
{

}
