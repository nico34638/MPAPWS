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
     * @var Product
     */
    private Product $product;

    /**
     * DeleteProductCommand constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }




}