<?php


namespace App\Domain\Query;

use App\Domain\CatalogOfProducts;

class OneProductHandler
{
    private $catalog;

    public function __construct(CatalogOfProducts $aCatalogOfProducts)
    {
        $this->catalog=$aCatalogOfProducts;
    }

    public function handle(OneProductQuery $query, $id): \App\Entity\Product
    {
        return $this->catalog->find($id);
    }
}