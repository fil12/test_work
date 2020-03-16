<?php

namespace App\Test\Services;

use App\Collections\PlayersCollection;
use App\Dto\Player;
use App\Dto\Selections\Scissors;
use App\Dto\Selections\Stone;
use App\Services\GameService;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    public function testPlayGamePlayer1Winner() {
        $service = new GameService();
        $player1 = new Player('Alex');
        $player1->setSelection(new Stone());

        $player2 = new Player('Mark');
        $player2->setSelection(new Scissors());

        $players = new PlayersCollection(...[$player1, $player2]);
        $winner = $service->playingGame($players);
        $this->assertInstanceOf(Player::class, $winner);
        $this->assertEquals($player1, $winner);
    }

    public function testPlayGamePlayer2Winner() {
        $service = new GameService();
        $player1 = new Player('Alex');
        $player1->setSelection(new Scissors());

        $player2 = new Player('Mark');
        $player2->setSelection(new Stone());

        $players = new PlayersCollection(...[$player1, $player2]);
        $winner = $service->playingGame($players);
        $this->assertInstanceOf(Player::class, $winner);
        $this->assertEquals($player2, $winner);
    }

    public function testPlayGameTie() {
        $service = new GameService();
        $player1 = new Player('Alex');
        $player1->setSelection(new Scissors());

        $player2 = new Player('Mark');
        $player2->setSelection(new Scissors());

        $players = new PlayersCollection(...[$player1, $player2]);
        $winner = $service->playingGame($players);
        $this->assertEquals(null, $winner);
    }
}
