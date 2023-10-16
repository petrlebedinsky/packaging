<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products_set')]
class ProductsSet
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    private string $id;

    #[ORM\OneToOne(targetEntity: Packaging::class)]
    #[ORM\JoinColumn(name: 'packaging_id', referencedColumnName: 'id', nullable: true)]
    private ?Packaging $packaging;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getPackaging(): ?Packaging
    {
        return $this->packaging;
    }

    public function setPackaging(?Packaging $packaging = null): self
    {
        $this->packaging = $packaging;
        return $this;
    }
}
