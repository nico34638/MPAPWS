<?php


namespace App\Domain\Query;

use App\Domain\CatalogOfProducts;

class ListProductsHandler
{
    private $catalog;

    public function __construct(CatalogOfProducts $aCatalogOfProducts)
    {
        $this->catalog=$aCatalogOfProducts;
    }

    public function handle(ListProductsQuery $query):iterable
    {
        return $this->catalog->allProducts();
    }
}