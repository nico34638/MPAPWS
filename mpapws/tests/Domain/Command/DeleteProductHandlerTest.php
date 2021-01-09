<?php


namespace App\Tests\Domain\Command;


use App\Domain\CatalogOfProducts;
use App\Domain\Command\DeleteProductCommand;
use App\Domain\Command\DeleteProductHandler;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class DeleteProductHandlerTest extends TestCase
{
    /**
     * Test delete product
     */
    public function test_add_a_product()
    {
        $product = $this->createMock(Product::class);

        $catalogOfProducts = $this->createMock(CatalogOfProducts::class);

        $handler = new DeleteProductHandler($catalogOfProducts);
        $command = new DeleteProductCommand($product);

        // Assert
        $catalogOfProducts->expects($this->once())->method("deleteProduct");

        $handler->handle($command);

    }
}