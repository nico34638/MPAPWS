<?php


namespace App\Tests\Domain\Command;

use App\Domain\CatalogOfMessages;
use App\Domain\CatalogOfUsers;
use App\Domain\Command\ContactFormCommand;
use App\Domain\Command\ContactFormHandler;
use App\Entity\Message;
use PHPUnit\Framework\TestCase;

/**
 * Class ContactFormHandlerTest
 * @package App\Tests\Domain\Command
 */
class ContactFormHandlerTest extends TestCase
{
    /**
     * Test messages add
     */
    public function test_add_a_message()
    {
        $message = $this->createMock(Message::class);

        $catalogOfMessages = $this->createMock(CatalogOfMessages::class);

        $handler = new ContactFormHandler($catalogOfMessages);
        $command = new ContactFormCommand($message);

        // Assert
        $catalogOfMessages->expects($this->once())->method("addMessage");

        $handler->handle($command);

    }
}