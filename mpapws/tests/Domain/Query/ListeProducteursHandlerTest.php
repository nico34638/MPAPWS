<?php


namespace App\Tests\Domain\Query;


use App\Domain\AnnuaireProducteur;
use App\Domain\Query\ListeProducteursHandler;
use App\Domain\Query\ListeProducteursQuery;
use PHPUnit\Framework\TestCase;

class ListeProducteursHandlerTest extends TestCase
{

    public function test_obtenir_la_liste_des_producteurs()
    {
        $query = new ListeProducteursQuery();
        $annuaireProducteurs = $this->createMock(AnnuaireProducteur::class);
        $annuaireProducteurs->expects($this->once())->method('tousLesProducteurs');

        $handler = new ListeProducteursHandler($annuaireProducteurs);
        $resultat = $handler->handle($query);
        $this->assertIsIterable($resultat);
    }

}