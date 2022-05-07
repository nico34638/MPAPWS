<?php


namespace App\Domain\Command;


use App\Domain\CatalogOfSubscribers;

/**
 * Class AddSubscriberHandler
 * @package App\Domain\Command
 */
class AddSubscriberHandler
{

    /**
     * AddSubscriberHandler constructor.
     * @param CatalogOfSubscribers $catalogOfSubscribers
     */
    public function __construct(private CatalogOfSubscribers $catalogOfSubscribers)
    {
    }

    public function handle(AddSubscriberCommand $command)
    {
        $this->catalogOfSubscribers->addSubscriber($command);
    }


}