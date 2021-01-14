<?php


namespace App\Domain\Command;


use App\Entity\Subscriber;

class DeleteSubscriberCommand
{
    private Subscriber $subscriber;

    /**
     * DeleteSubscriberCommand constructor.
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function getSubscriber()
    {
        return $this->subscriber;
    }
}