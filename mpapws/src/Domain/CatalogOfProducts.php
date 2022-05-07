<?php


namespace App\Domain;

use App\Domain\Command\AddProductCommand;
use App\Domain\Command\DeleteProductCommand;
use App\Domain\Query\SearchProductQuery;
use App\Entity\Product;

/**
 * Interface CatalogOfProducts
 * @package App\Domain
 */
interface CatalogOfProducts
{
    public function allProducts(): iterable;

    /**
     * @return mixed
     */
    public function addProduct(AddProductCommand $command);

    /**
     * return mixed
     */
    public function searchProduct(SearchProductQuery $query);

    /**
     * @return mixed
     */
    public function deleteProduct(DeleteProductCommand $command);
}