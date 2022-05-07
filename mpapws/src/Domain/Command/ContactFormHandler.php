<?php


namespace App\Domain\Command;

use App\Domain\CatalogOfMessages;

/**
 * Class ContactFormHandler
 * @package App\Domain\Command
 */
class ContactFormHandler
{
    /**
     * RegisterHandler constructor.
     * @param CatalogOfMessages $catalogOfMessages
     */
    public function __construct(private CatalogOfMessages $catalogOfMessages)
    {
    }

    public function handle(ContactFormCommand $command)
    {
        $this->catalogOfMessages->addMessage($command);
    }
}