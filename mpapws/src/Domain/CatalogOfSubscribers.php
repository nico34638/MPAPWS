<?php


namespace App\Domain;


use App\Domain\Command\AddSubscriberCommand;
use App\Domain\Command\DeleteSubscriberCommand;

interface CatalogOfSubscribers
{

    public function addSubscriber(AddSubscriberCommand $command);

    public function allSubscribers(): iterable;

    public function deleteSubscriber(DeleteSubscriberCommand $command);

    public function findByCode($code);
}