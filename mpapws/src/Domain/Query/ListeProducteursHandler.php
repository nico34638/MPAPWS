<?php


namespace App\Domain\Query;


use App\Domain\AnnuaireProducteur;

class ListeProducteursHandler
{

    private $annuaireProducteurs;

    public function __construct(AnnuaireProducteur $annuaireProducteurs)
    {
        $this->annuaireProducteurs = $annuaireProducteurs;
    }

    public function handle(ListeProducteursQuery $query): iterable
    {
        return $this->annuaireProducteurs->tousLesProducteurs();
    }
}