<?php


namespace App\Domain\Query;


use App\Domain\CatalogOfProducers;

class detailProducerHandler
{

    public function __construct(private CatalogOfProducers $catalog)
    {
    }

    public function handle(detailProducerQuery $query, $username)
    {
        return $this->catalog->findOneBy(['username' => $username]);
    }
}