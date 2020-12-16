<?php


namespace App\Tests\Domain\Query;

use App\Domain\CatalogOfProducts;
use App\Domain\Query\ListProductsHandler;
use App\Domain\Query\ListProductsQuery;
use PHPUnit\Framework\TestCase;

class ListProductsHandlerTest extends TestCase
{
    public function test_obtain_the__list_of_products_query_list(){

        // Arrange
        $query = $this->createMock(ListProductsQuery::class);
        $catalog = $this->createMock(CatalogOfProducts::class);
        $handler = new ListProductsHandler($catalog);

        // Assert
        $catalog->expects($this->once())->method("allProducts");

        // Act
        $listProducts = $handler->handle($query);
        $this->assertIsIterable($listProducts);
    }
}