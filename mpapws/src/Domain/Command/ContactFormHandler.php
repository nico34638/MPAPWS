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
     * @var CatalogOfMessages
     */
    private CatalogOfMessages $catalogOfMessages;

    /**
     * RegisterHandler constructor.
     * @param CatalogOfMessages $catalogOfMessages
     */
    public function __construct(CatalogOfMessages $catalogOfMessages)
    {
        $this->catalogOfMessages = $catalogOfMessages;
    }

    /**
     * @param ContactFormCommand $command
     */
    public function handle(ContactFormCommand $command)
    {
        $this->catalogOfMessages->addMessage($command);
    }
}