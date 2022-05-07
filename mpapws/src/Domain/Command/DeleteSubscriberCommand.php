<?php


namespace App\Domain\Command;


use App\Entity\Subscriber;

class DeleteSubscriberCommand
{
    /**
     * DeleteSubscriberCommand constructor.
     */
    public function __construct(private Subscriber $subscriber)
    {
    }

    public function getSubscriber()
    {
        return $this->subscriber;
    }
}