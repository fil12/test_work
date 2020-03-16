<?php

namespace App\Services;

use App\Collections\PlayersCollection;
use App\Dto\Player;
use App\Dto\Selections\Paper;
use App\Dto\Selections\Scissors;
use App\Dto\Selections\Stone;
use App\Exceptions\CanNotGetResult;

class GameService
{
    public function playingGame(PlayersCollection $playersCollection)
    {
        $players = $playersCollection->getIterator();
        $choices = [];

        /** @var Player $player */
        foreach ($players as $k => $player) {
            $choices[] = $this->getChoiceForPlayer($player);
        }

        return $this->getResult($choices, $players);
    }

    private function getChoiceForPlayer(Player $player)
    {
        $selections = $player->getSelection();
        $choice = array_rand($selections);

        return $selections[$choice];
    }

     private function getResult(array $choices, Iterable $players)
    {
        if ($choices[0] instanceof Stone && $choices[1] instanceof Scissors ||
            $choices[0] instanceof Scissors && $choices[1] instanceof Paper ||
            $choices[0] instanceof Paper && $choices[1] instanceof Stone
        ) {
            return $players[0];
        } elseif ($choices[1] instanceof Stone && $choices[0] instanceof Scissors ||
            $choices[1] instanceof Scissors && $choices[0] instanceof Paper ||
            $choices[1] instanceof Paper && $choices[0] instanceof Stone
        ) {
            return $players[1];
        } elseif ($choices[0] == $choices[1]) {
            return null;
        }
        throw new CanNotGetResult('Can not get any result for this game.');
    }
}