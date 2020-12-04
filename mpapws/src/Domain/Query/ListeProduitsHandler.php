<?php


namespace App\Domain\Query;

use App\Domain\AnnuaireDeProduits;

class ListeProduitsHandler
{
    private $annuaire;

    public function __construct(AnnuaireDeProduits $annuaireDeProduits)
    {
        $this->annuaire=$annuaireDeProduits;
    }

    public function handle(ListeProduitsQuery $requete):iterable
    {
        return $this->annuaire->tousLesProduits();
    }
}