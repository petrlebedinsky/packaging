<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

readonly class Product
{
    public function __construct(
        #[Assert\Positive]
        private int $id,
        #[Assert\Positive]
        private float $width,
        #[Assert\Positive]
        private float $height,
        #[Assert\Positive]
        private float $length,
        #[Assert\Positive]
        private float $weight,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getLength(): float
    {
        return $this->length;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @return array{biggest: float, mid: float, lowest: float}
     */
    public function getSortedDimensions(): array
    {
        $dimensions = [$this->width, $this->height, $this->length];
        rsort($dimensions);
        return [
            'biggest' => $dimensions[0],
            'mid' => $dimensions[1],
            'lowest' => $dimensions[2],
        ];
    }
}
