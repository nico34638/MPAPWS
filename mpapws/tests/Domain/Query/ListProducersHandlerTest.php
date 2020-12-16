<?php


namespace App\Tests\Domain\Query;


use App\Domain\CatalogOfProducers;
use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducersQuery;
use PHPUnit\Framework\TestCase;

class ListProducersHandlerTest extends TestCase
{

    public function test_obtain_the_producer_list()
    {
        $query = $this->createMock(ListProducersQuery::class);
        $catalogueOfProducer = $this->createMock(CatalogOfProducers::class);
        $handler = new ListProducersHandler($catalogueOfProducer);

        $catalogueOfProducer->expects($this->once())->method('allProducers');

        $result = $handler->handle($query);
        $this->assertIsIterable($result);
    }
}