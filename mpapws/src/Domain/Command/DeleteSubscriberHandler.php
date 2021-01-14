<?php


namespace App\Domain\Command;

use App\Domain\CatalogOfSubscribers;

class DeleteSubscriberHandler
{
    private CatalogOfSubscribers $catalogOfSubscribers;

    public function __construct(CatalogOfSubscribers $catalogOfSubscribers)
    {
        $this->catalogOfSubscribers = $catalogOfSubscribers;
    }

    public function handle(DeleteSubscriberCommand $command)
    {
        $this->catalogOfSubscribers->deleteSubscriber($command);
    }

    public function find($code){
        return $this->catalogOfSubscribers->findByCode($code);
    }
}