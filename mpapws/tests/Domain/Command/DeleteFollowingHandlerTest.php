<?php


namespace App\Tests\Domain\Command;


use App\Domain\CatalogOfUsers;
use App\Domain\Command\DeleteFollowingCommand;
use App\Domain\Command\DeleteFollowingHandler;
use App\Domain\Command\DeleteProductHandler;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteFollowingHandlerTest
 * @package App\Tests\Domain\Command
 */
class DeleteFollowingHandlerTest extends TestCase
{
    /**
     * test delete a favorites
     */
    public function test_delete_a_favorites()
    {
        $user = $this->createMock(User::class);
        $producer =$this->createMock(User::class);

        $catalogOfUser = $this->createMock(CatalogOfUsers::class);

        $handler = new DeleteFollowingHandler($catalogOfUser);
        $command = new DeleteFollowingCommand($user, $producer);

        // Assert
        $catalogOfUser->expects($this->once())->method("deleteFollowing");

        $handler->handle($command);

    }
}