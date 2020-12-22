<?php


namespace App\Tests\Domain\Command;


use App\Domain\CatalogOfUsers;
use App\Domain\Command\RegisterCommand;
use App\Domain\Command\RegisterHandler;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class addProductHandlerTest
 * @package App\Tests\Domain\Command
 */
class RegisterHandlerTest extends TestCase
{
    /**
     * Test register user
     */
    public function test_add_a_user()
    {
        $user = $this->createMock(User::class);

        $catalogOfUsers = $this->createMock(CatalogOfUsers::class);

        $handler = new RegisterHandler($catalogOfUsers);
        $command = new RegisterCommand($user);

        // Assert
        $catalogOfUsers->expects($this->once())->method("addUser");

        $handler->handle($command);

    }
}