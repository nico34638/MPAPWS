<?php


namespace App\Domain\Query;

use App\Domain\CatalogueOfProducts;

class ListeProductsHandler
{
    private $annuaire;

    public function __construct(CatalogueOfProducts $annuaireDeProduits)
    {
        $this->annuaire=$annuaireDeProduits;
    }

    public function handle(ListeProductsQuery $requete):iterable
    {
        return $this->annuaire->tousLesProduits();
    }
}