<?php


namespace App\Tests\Domain\Query;

use App\Domain\CatalogOfProducers;
use App\Domain\Query\ListOfFavoritesHandler;
use App\Domain\Query\ListOfFavoritesQuery;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class ListOfFavoritesHandlerTest
 * @package App\Tests\Domain\Query
 */
class ListOfFavoritesHandlerTest extends TestCase
{
    /**
     * Test list of favorites
     */
    public function test_list_of_favorites()
    {
        $user = $this->createMock(User::class);
        $query = new ListOfFavoritesQuery($user);
        $catalogueOfProducer = $this->createMock(CatalogOfProducers::class);
        $handler = new ListOfFavoritesHandler($catalogueOfProducer);

        $catalogueOfProducer->expects($this->once())->method('allFavorites');

        $result = $handler->handle($query);
        $this->assertIsIterable($result);
    }
}