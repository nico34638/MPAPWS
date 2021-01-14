<?php


namespace App\Tests\Domain\Query;


use App\Domain\CatalogOfProducts;
use App\Domain\Query\ListProductsHandler;
use App\Domain\Query\ListProductsQuery;
use App\Domain\Query\SearchProductHandler;
use App\Domain\Query\SearchProductQuery;
use PHPUnit\Framework\TestCase;

/**
 * Class SearchProductHandlerTest
 * @package App\Tests\Domain\Query
 */
class SearchProductHandlerTest extends TestCase
{
    /**
     * Test search handler
     */
    public function test_obtain_the__list_of_products_search()
    {

        // Arrange
        $query = $this->createMock(SearchProductQuery::class);
        $catalog = $this->createMock(CatalogOfProducts::class);
        $handler = new SearchProductHandler($catalog);

        // Assert
        $catalog->expects($this->once())->method("searchProduct");

        // Act
        $listProducts = $handler->handle($query);
    }
}