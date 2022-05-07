<?php


namespace App\Domain\Command;


use App\Entity\Message;

class ContactFormCommand{
    /**
     * AddSubscriberCommand constructor.
     * @param $message
     */
    public function __construct(private Message $message)
    {
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

}