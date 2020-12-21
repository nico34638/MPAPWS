<?php


namespace App\Domain\Command;


use App\Domain\CatalogOfProducts;

/**
 * Class AddProductHandler
 * @package App\Domain\Command
 */
class AddProductHandler
{

    /**
     * @var CatalogOfProducts
     */
    private CatalogOfProducts $catalogOfProducts;

    /**
     * AddProductHandler constructor.
     * @param CatalogOfProducts $catalogOfProducts
     */
    public function __construct(CatalogOfProducts $catalogOfProducts)
    {
        $this->catalogOfProducts = $catalogOfProducts;
    }

    /**
     * @param AddProductCommand $command
     */
    public function handle(AddProductCommand $command)
    {
        $this->catalogOfProducts->addProduct($command);
    }


}