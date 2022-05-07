<?php


namespace App\Domain\Query;

use App\Domain\CatalogOfProducts;

class ListProductsHandler
{
    public function __construct(private CatalogOfProducts $catalog)
    {
    }

    public function handle(ListProductsQuery $query):iterable
    {
        return $this->catalog->allProducts();
    }
}