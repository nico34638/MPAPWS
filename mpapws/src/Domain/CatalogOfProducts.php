<?php


namespace App\Domain;

use App\Domain\Command\AddProductCommand;
use App\Entity\Product;

/**
 * Interface CatalogOfProducts
 * @package App\Domain
 */
interface CatalogOfProducts
{
    /**
     * @return iterable
     */
    public function allProducts(): iterable;

    /**
     * @return mixed
     */
    public function addProduct(AddProductCommand $command);

}