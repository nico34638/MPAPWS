<?php


namespace App\Tests\Domain\Query;

use App\Domain\CatalogueOfProducts;
use App\Domain\Query\ListeProductsHandler;
use App\Domain\Query\ListeProductsQuery;
use PHPUnit\Framework\TestCase;

class ListeProduitsHandlerTest extends TestCase
{
    public function test_obtenir_la_liste_de_produits_interroge_l_annuaire(){

        // Arrange
        $requete = $this->createMock(ListeProductsQuery::class);
        $annuaire = $this->createMock(CatalogueOfProducts::class);
        $handler = new ListeProductsHandler($annuaire);

        // Assert
        $annuaire->expects($this->once())->method("tousLesProduits");

        // Act
        $listeDeProduits = $handler->handle($requete);
        $this->assertIsIterable($listeDeProduits);
    }
}