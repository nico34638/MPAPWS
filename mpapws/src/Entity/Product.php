<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sourceImage;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $producers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSourceImage(): ?string
    {
        return $this->sourceImage;
    }

    public function setSourceImage(string $sourceImage): self
    {
        $this->sourceImage = $sourceImage;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getProducers(): ?User
    {
        return $this->producers;
    }

    public function setProducers(?User $producers): self
    {
        $this->producers = $producers;

        return $this;
    }
}
