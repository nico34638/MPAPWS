<?php


namespace App\Tests\Domain\Command;


use App\Domain\CatalogOfProducts;
use App\Domain\Command\AddProductCommand;
use App\Domain\Command\AddProductHandler;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class addProductHandlerTest extends TestCase
{
    public function test_add_a_product()
    {
        $product = $this->createMock(Product::class);

        $catalogOfProducts = $this->createMock(CatalogOfProducts::class);

        $handler = new AddProductHandler($catalogOfProducts);
        $command  = new AddProductCommand($product);

        // Assert
        $catalogOfProducts->expects($this->once())->method("addProduct");

        $handler->handle($command);

    }
}