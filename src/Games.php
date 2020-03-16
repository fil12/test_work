<?php
/**
 * Created by PhpStorm.
 * User: dev-alexf
 * Date: 15.02.19
 * Time: 12:28
 */

namespace App;

use App\Collections\PlayersCollection;
use App\Dto\Player;
use App\Dto\Selections\Paper;
use App\Dto\Selections\Scissors;
use App\Dto\Selections\Stone;
use App\Services\GameService;

class Games
{

    private $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function playStoneScissorsPaper(PlayersCollection $players)
    {
        $this->gameService->playingGame($players);

        return $this->gameService->playingGame($players);
    }

    public function getPlayers(): PlayersCollection
    {
        $player1 = new Player('Mark');
        $player2 = new Player('Alex');

        $player1->setSelection(new Scissors());

        $player2->setSelection(new Scissors());
        $player2->setSelection(new Stone());
        $player2->setSelection(new Paper());

        return new PlayersCollection(...[$player1, $player2]);
    }
}
