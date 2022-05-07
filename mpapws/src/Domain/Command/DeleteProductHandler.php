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
     * DeleteProductHandler constructor.
     * @param CatalogOfProducts $catalogOfProducts
     */
    public function __construct(private CatalogOfProducts $catalogOfProducts)
    {
    }

    public function handle(DeleteProductCommand $command)
    {
        $this->catalogOfProducts->deleteProduct($command);
    }
}