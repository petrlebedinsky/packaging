<?php

declare(strict_types=1);

namespace App\Service\Packaging;

use App\Model\Box;

class Calculator
{
    /**
     * @param FinderInterface[] $packagingFinders
     */
    public function __construct(private array $packagingFinders)
    {
    }

    public function findPackaging(): Box
    {
        foreach($this->packagingFinders as $finder) {
            $box = $finder->findBox();
            if ($box !== null) {
                return $box;
            }
        }
        //@TODO: handle missing box
    }

    public function addPackagingFinder(FinderInterface $finder): void
    {
        $this->packagingFinders[] = $finder;
    }
}
