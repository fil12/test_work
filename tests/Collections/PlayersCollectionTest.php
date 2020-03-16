<?php

namespace App\Test\Collections;

use App\Collections\PlayersCollection;
use App\Dto\Player;
use PHPUnit\Framework\TestCase;

class PlayersCollectionTest extends TestCase
{

    public function testGetIterator()
    {
        $collection = new PlayersCollection();
        $collection->addPlayer(new Player('Alex'));
        $collection->addPlayer(new Player('Mark'));

        $players = $collection->getIterator();
        $this->assertInstanceOf(Player::class, $players[0]);
        $this->assertInstanceOf(Player::class, $players[1]);
        $this->assertEquals('Alex', $players[0]->name);
        $this->assertEquals('Mark', $players[1]->name);
    }
}
