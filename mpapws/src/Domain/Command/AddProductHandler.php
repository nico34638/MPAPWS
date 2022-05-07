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
     * AddProductHandler constructor.
     * @param CatalogOfProducts $catalogOfProducts
     */
    public function __construct(private CatalogOfProducts $catalogOfProducts)
    {
    }

    public function handle(AddProductCommand $command)
    {
        $this->catalogOfProducts->addProduct($command);
    }


}