<?php


namespace App\Domain\Query;

use App\Domain\CatalogOfProducts;

class OneProductHandler
{
    public function __construct(private CatalogOfProducts $catalog)
    {
    }

    public function handle(OneProductQuery $query, $id): \App\Entity\Product
    {
        return $this->catalog->find($id);
    }
}