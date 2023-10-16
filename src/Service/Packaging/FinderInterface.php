<?php

declare(strict_types=1);

namespace App\Service\Packaging;

use App\Model\Box;

interface FinderInterface
{
    public function findBox(): ?Box;
}
