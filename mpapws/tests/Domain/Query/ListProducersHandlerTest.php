<?php


namespace App\Tests\Domain\Query;


use App\Domain\CatalogueOfProducer;
use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducerQuery;
use PHPUnit\Framework\TestCase;

class ListProducersHandlerTest extends TestCase
{

    public function test_obtenir_la_liste_des_producteurs()
    {
        $query = new ListProducerQuery();
        $catalogueOfProducer = $this->createMock(CatalogueOfProducer::class);
        $catalogueOfProducer->expects($this->once())->method('allProducers');

        $handler = new ListProducersHandler($catalogueOfProducer);
        $resultat = $handler->handle($query);
        $this->assertIsIterable($resultat);
    }

}