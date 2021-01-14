<?php


namespace App\Domain\Command;

use App\Domain\CatalogOfProducts;

/**
 * Class DeleteProductHandler
 * @package App\Domain\Command
 */
class DeleteProductHandler
{
    /**
     * @var CatalogOfProducts
     */
    private CatalogOfProducts $catalogOfProducts;

    /**
     * DeleteProductHandler constructor.
     * @param CatalogOfProducts $catalogOfProducts
     */
    public function __construct(CatalogOfProducts $catalogOfProducts)
    {
        $this->catalogOfProducts = $catalogOfProducts;
    }

    /**
     * @param DeleteProductCommand $command
     */
    public function handle(DeleteProductCommand $command)
    {
        $this->catalogOfProducts->deleteProduct($command);
    }
}