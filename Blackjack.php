<?php

class Blackjack
{
    public function scoreHand(array $hand): string
    {
        $playerScore = 0;
        foreach ($hand as $key => $card) {
            $playerScore += $card->score();
        }

        $result = '';

        if ($playerScore == 21) {
            if (!count($hand) == 2) {
                $result = 'Blackjack!';
            } else {
                $result = 'Twenty-one!';
            }
        } elseif ($playerScore < 21) {
            if (count($hand) == 5) {
                $result = 'Five Card Charlie!';
            } else {
                $result = $playerScore;
            }
        } else {
            $result = 'Busted!';
        }
        return $result;
    }
}
