<?php


namespace App\Domain\Command;


use App\Entity\Product;

class AddProductCommand
{
    /**
     * AddProductCommand constructor.
     * @param $product
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