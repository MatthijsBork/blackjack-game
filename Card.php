<?php

class Card
{
    private string $suit;
    private string $value;

    private array $translation_suit = [
        'schoppen' => '♠',
        'klaveren' => '♣',
        'harten' => '♥',
        'ruiten' => '♦'
    ];

    private array $translation_value = [
        'vrouw' => 'V',
        'boer' => 'B',
        'koning' => 'K',
        'aas' => 'A'
    ];

    private function validateSuit($suit): bool
    {
        if (!array_key_exists($suit, $this->translation_suit)) {
            throw new InvalidArgumentException();
        } else {
            return true;
        }
    }

    private function validateValue($value): bool
    {
        if (!array_key_exists($value, $this->translation_value)) {
            if (!($value >= 2) && ($value <= 11)) {
                echo $value;
                throw new InvalidArgumentException();
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function __construct(string $suit, string $value)
    {
        if (!empty($suit || $value)) {
            if ($this->validateSuit($suit) && $this->validateValue($value)) {
                $this->value = $value;
                $this->suit = $suit;
            }
        } else {
            throw new Exception('Missing needed properties');
        }
    }

    public function show(): string
    {
        $suit = $this->suit;
        $value = $this->value;

        if (!empty($suit || $value)) {
            // Zet kaarten om in symbool voor weergave
            $suit = $this->translation_suit[$suit];
            if (!is_numeric($value)) {
                $value = $this->translation_value[$value];
            }
            return $suit . $value . ' ';
        } else {
            return 'Kaart niet gevonden';
        }
    }

    public function score(): int
    {
        $values = [
            'vrouw' => '10',
            'boer' => '10',
            'koning' => '10',
            'aas' => '11'
        ];

        if (!is_numeric($this->value)) {
            $score = $values[$this->value];
        } else {
            $score = $this->value;
        }
        return $score;
    }
}
