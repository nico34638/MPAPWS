<?php


namespace App\Query;



use App\AnnuaireDeProduits;

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