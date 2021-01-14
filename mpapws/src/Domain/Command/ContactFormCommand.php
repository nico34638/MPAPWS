<?php


namespace App\Domain\Command;


use App\Entity\Message;

class ContactFormCommand{
    /**
    * @var Message
    */
    private Message $message;

    /**
     * AddSubscriberCommand constructor.
     * @param $message
     */
    public function __construct(Message $message){
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

}