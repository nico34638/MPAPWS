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
     * @var CatalogOfSubscribers
     */
    private CatalogOfSubscribers $catalogOfSubscribers;

    /**
     * AddSubscriberHandler constructor.
     * @param CatalogOfSubscribers $catalogOfSubscribers
     */
    public function __construct(CatalogOfSubscribers $catalogOfSubscribers)
    {
        $this->catalogOfSubscribers = $catalogOfSubscribers;
    }

    /**
     * @param AddSubscriberCommand $command
     */
    public function handle(AddSubscriberCommand $command)
    {
        $this->catalogOfSubscribers->addSubscriber($command);
    }


}