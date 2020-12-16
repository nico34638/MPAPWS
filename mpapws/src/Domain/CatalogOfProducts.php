<?php


namespace App\Domain;


interface CatalogOfProducts
{
    /**
     * @return iterable
     */
    public function allProducts(): iterable;
}