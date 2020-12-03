<?php


namespace App;


use App\AnnuaireDeProduits;
use App\Query\ListeProduitsHandler;
use App\Query\ListeProduitsQuery;
use PHPUnit\Framework\TestCase;

class ListeProduitsHandlerTest extends TestCase
{
    public function test_obtenir_la_liste_de_cinemas_interroge_l_annuaire(){

        // Arrange
        $requete = new ListeProduitsQuery();
        $annuaire = $this->createMock(AnnuaireDeProduits::class);
        $handler = new ListeProduitsHandler($annuaire);

        // Assert
        $annuaire->expects($this->once())->method("tousLesProduits");

        // Act
        $listeDeProduits = $handler->handle($requete);
    }
}