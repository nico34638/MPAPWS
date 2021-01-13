<?php


namespace App\Domain;

use App\Domain\Command\AddSubscriberCommand;
use App\Entity\Subscriber;

/**
 * Interface CatalogOfSubscribers
 * @package App\Domain
 */
interface CatalogOfSubscribers
{
    /**
     * @return iterable
     */
    public function allSubscribers(): iterable;

    /**
     * @return mixed
     */
    public function addSubscriber(AddSubscriberCommand $command);

}