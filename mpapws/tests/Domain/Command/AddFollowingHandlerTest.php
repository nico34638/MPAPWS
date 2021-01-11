<?php


namespace App\Tests\Domain\Command;


use App\Domain\CatalogOfUsers;
use App\Domain\Command\AddFollowingCommand;
use App\Domain\Command\AddFollowingHandler;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AddFollowingHandlerTest extends  TestCase
{
    public function test_add_a_favorites()
    {
        $user = $this->createMock(User::class);
        $producer =$this->createMock(User::class);

        $catalogOfProducts = $this->createMock(CatalogOfUsers::class);

        $handler = new AddFollowingHandler($catalogOfProducts);
        $command = new AddFollowingCommand($user, $producer);

        // Assert
        $catalogOfProducts->expects($this->once())->method("addFollowing");

        $handler->handle($command);

    }
}