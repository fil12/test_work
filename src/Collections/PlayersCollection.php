<?php

namespace App\Collections;

use App\Dto\Player;
use ArrayIterator;
use IteratorAggregate;

final class PlayersCollection implements IteratorAggregate
{
    private $players;

    public function __construct(Player ...$players)
    {
        $this->players = $players;
    }

    public function addPlayer(Player $player): void
    {
        $this->players[] = $player;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->players);
    }
}
