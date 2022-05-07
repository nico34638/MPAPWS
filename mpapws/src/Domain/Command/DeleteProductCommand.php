<?php


namespace App\Domain\Command;

use App\Entity\Product;

/**
 * Class DeleteProductCommand
 * @package App\Domain\Command
 */
class DeleteProductCommand
{
    /**
     * DeleteProductCommand constructor.
     * @param Product $product
     */
    public function __construct(private Product $product)
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }




}