<?php


namespace App\Domain\Query;



use App\Domain\CatalogOfSubscribers;

class ListSubscribersHandler
{
    private $catalog;

    public function __construct(CatalogOfSubscribers $aCatalogOfSubscribers)
    {
        $this->catalog=$aCatalogOfSubscribers;
    }

    public function handle(ListSubscribersQuery $query):iterable
    {
        return $this->catalog->allSubscribers();
    }
}