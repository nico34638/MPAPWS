<?php


namespace App\Domain\Query;

use App\Domain\CatalogOfSubscribers;

class ListSubscribersHandler
{
    public function __construct(private CatalogOfSubscribers $catalog)
    {
    }

    public function handle(ListSubscribersQuery $query):iterable
    {
        return $this->catalog->allSubscribers();
    }
}