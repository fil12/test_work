<?php

namespace App\Dto;

use App\Dto\Selections\Selection;

class Player
{
    public $name;
    private $selection;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getSelection(): array
    {
        return $this->selection;
    }

    public function setSelection(Selection $selection): void
    {
        $this->selection[] = $selection;
    }
}
