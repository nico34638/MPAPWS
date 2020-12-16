<?php


namespace App\Domain;

/**
 * Interface CatalogOfProducers
 * @package App\Domain
 */
interface CatalogOfProducers
{
    /**
     * @return iterable
     */
    public function allProducers(): iterable;
}