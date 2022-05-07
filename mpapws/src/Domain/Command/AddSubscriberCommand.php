<?php


namespace App\Domain\Command;


use App\Entity\Subscriber;

class AddSubscriberCommand
{
    /**
     * AddSubscriberCommand constructor.
     * @param $subscriber
     */
    public function __construct(private Subscriber $subscriber)
    {
    }

    public function getSubscriber(): Subscriber
    {
        return $this->subscriber;
    }

    public function setSubscriber(Subscriber $subscriber): void
    {
        $this->subscriber = $subscriber;
    }




}