<?php


namespace App\Domain\Command;


use App\Entity\Subscriber;

class AddSubscriberCommand
{
    /**
     * @var Subscriber
     */
    private Subscriber $subscriber;

    /**
     * AddSubscriberCommand constructor.
     * @param $subscriber
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @return Subscriber
     */
    public function getSubscriber(): Subscriber
    {
        return $this->subscriber;
    }

    /**
     * @param Subscriber $subscriber
     */
    public function setSubscriber(Subscriber $subscriber): void
    {
        $this->subscriber = $subscriber;
    }




}