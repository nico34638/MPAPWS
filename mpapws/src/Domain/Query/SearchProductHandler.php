<?php


namespace App\Domain\Query;


use App\Domain\CatalogOfProducts;

/**
 * Class SearchProductHandler
 * @package App\Domain\Query
 */
class SearchProductHandler
{
    /**
     * @var CatalogOfProducts
     */
    private CatalogOfProducts $catalogOfProduct;

    /**
     * SearchProductHandler constructor.
     * @param CatalogOfProducts $aCatalogOfProducts
     */
    public function __construct(CatalogOfProducts $aCatalogOfProducts)
    {
        $this->CatalogOfProducts = $aCatalogOfProducts;
    }

    /**
     * @return mixed
     */
    public function handle(SearchProductQuery $query)
    {
        return $this->CatalogOfProducts->searchProduct($query);
    }


}