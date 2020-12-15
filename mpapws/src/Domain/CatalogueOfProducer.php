<?php


namespace App\Domain;

/**
 * Interface CatalogueOfProducer
 * @package App\Domain
 */
interface CatalogueOfProducer
{
    /**
     * @return iterable
     */
    public function allProducers(): iterable;
}