<?php


namespace App\Domain;


interface CatalogueOfProducts
{
    public function tousLesProduits():iterable;
}