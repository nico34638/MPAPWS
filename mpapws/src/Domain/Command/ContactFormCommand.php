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

}