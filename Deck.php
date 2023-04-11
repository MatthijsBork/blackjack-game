<?php

class Deck
{
    private array $cards = [];


    public function __construct()
    {
        $suits = [
            'schoppen' => '♠',
            'klaveren' => '♣',
            'harten' => '♥',
            'ruiten' => '♦'
        ];

        $values = [
            'vrouw' => 'V',
            'boer' => 'B',
            'koning' => 'K',
            'aas' => 'A'
        ];

        // Maakt alle suits met alle nummer-waardes
        foreach ($suits as $suit => $suit_symbol) {
            for ($i = 2; $i < 11; $i++) {
                array_push($this->cards, new Card($suit, $i));
            }
            // Maakt alle suits met alle plaatjes (Koning, etc.)
            foreach ($values as $value => $value_symbol) {
                array_push($this->cards, new Card($suit, $value));
            }
        }
    }

    public function drawCard(): Card
    {
        if (!empty($this->cards)) {
            // Pak een random kaart uit het deck
            $card = array_rand($this->cards);
            $drawn = $this->cards[$card];
            // Verwijder kaart uit het deck
            unset($this->cards[$card]);
        } else {
            throw new Exception();
        }
        return $drawn;
    }

    public function cards(): array
    {
        return $this->cards;
    }
}
