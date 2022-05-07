<?php


namespace App\Domain\Command;

use App\Domain\CatalogOfSubscribers;

class DeleteSubscriberHandler
{
    public function __construct(private CatalogOfSubscribers $catalogOfSubscribers)
    {
    }

    public function handle(DeleteSubscriberCommand $command)
    {
        $this->catalogOfSubscribers->deleteSubscriber($command);
    }

    public function find($code){
        return $this->catalogOfSubscribers->findByCode($code);
    }
}