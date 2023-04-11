<?php

class Player
{
    private string $name;
    private array $hand = [];
    public bool $lost = false;

    public function __construct(string $name)
    {
        if (!empty($name)) {
            $this->name = $name;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function addCard(Card $card): void
    {
        array_push($this->hand, $card);
    }

    public function showHand(): string
    {
        $inhand = [];
        foreach ($this->hand as $key => $card) {
            array_push($inhand, $card->show());
        }
        return  $this->name . ' has: ' . implode(', ', $inhand);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hand(): array
    {
        return $this->hand;
    }

    public function lost(): bool
    {
        return $this->lost;
    }
}
