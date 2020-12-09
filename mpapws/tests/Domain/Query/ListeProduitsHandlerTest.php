<?php


namespace App\Tests\Domain\Query;

use App\Domain\AnnuaireDeProduits;
use App\Domain\Query\ListeProduitsHandler;
use App\Domain\Query\ListeProduitsQuery;
use PHPUnit\Framework\TestCase;

class ListeProduitsHandlerTest extends TestCase
{
    public function test_obtenir_la_liste_de_produits_interroge_l_annuaire(){

        // Arrange
        $requete = $this->createMock(ListeProduitsQuery::class);
        $annuaire = $this->createMock(AnnuaireDeProduits::class);
        $handler = new ListeProduitsHandler($annuaire);

        // Assert
        $annuaire->expects($this->once())->method("tousLesProduits");

        // Act
        $listeDeProduits = $handler->handle($requete);
        $this->assertIsIterable($listeDeProduits);
    }
}