<?php

class Dealer
{
    private array $players = [];
    private object $deck;
    private object $blackjack;
    private int $playerCount = 1;

    public function __construct(Blackjack $blackjack, Deck $deck)
    {
        if (!empty($blackjack && $deck)) {
            $this->blackjack = $blackjack;
            $this->deck = $deck;
            $this->addPlayer(new Player('Dealer'));
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function getScore(Player $player): string
    {
        return $this->blackjack->scoreHand($player->hand());
    }

    public function addPlayer(Player $player)
    {
        if (!empty($player)) {
            array_push($this->players, $player);
            $this->playerCount++;
        } else {
            throw new InvalidArgumentException();
        }
    }

    private function draw(Player $player): void
    {
        $card = $this->deck->drawCard();
        $player->addCard($card);
        echo $player->name() . ' trok: ' . $card->show() . PHP_EOL;
        $this->decideFate($player);
    }

    private function showResults(): void
    {
        echo PHP_EOL . 'Resultaten:' . PHP_EOL;
        foreach ($this->players as $player) {
            if (!is_numeric($this->getScore($player))) {
                echo $player->showHand() . ' -> ' . $this->getScore($player) . PHP_EOL;
            } else {
                echo $player->showHand() . ': ' . $this->getScore($player) . PHP_EOL;
            }
        }
        die();
    }

    private function compare(Player $player): void
    {
        $dealer = (object)[];
        foreach ($this->players as $p) {
            if ($p->name() == 'Dealer') {
                $dealer = $p;
                break;
            }
        }

        if ($this->getScore($player) > $this->getScore($dealer)) {
            echo $player->name() . ' has won from the dealer!' . PHP_EOL;
            $this->showResults();
        } elseif ($this->getScore($player) == $this->getScore($dealer)) {
            echo $player->name() . ' has tied with the dealer!' . PHP_EOL;
            $this->showResults();
        } else {
            echo $player->name() . ' has lost from the dealer!' . PHP_EOL;
            $player->lost = true;
        }
    }

    private function decideFate(Player $player): void
    {
        if (!is_numeric($this->getScore($player))) {
            if ($this->getScore($player) != 'Busted!') {
                $this->showResults();
            } else {
                if ($player->name() == 'Dealer') {
                    echo PHP_EOL . 'Dealer lost!';
                    $this->showResults();
                } else {
                    echo $player->showHand() . ' -> ' . $this->getScore($player) . PHP_EOL;
                    $player->lost = true;
                    $this->playerCount--;
                }
            }
        }
    }

    public function playGame(): void
    {
        if (count($this->deck->cards()) == 52) {
            foreach ($this->players as $player) {
                for ($i = 0; $i < 2; $i++) {
                    $card = $this->deck->drawCard();
                    $player->addCard($card);
                }
            }
        } else {
            echo 'Incomplete deck!';
            die();
        }
        while ($this->playerCount > 1) {
            foreach ($this->players as $player) {
                $playerName = $player->name();
                $playerHand = $player->showHand();
                $this->decideFate($player);
                if ($player->name() != 'Dealer') {
                    if (!$player->lost) {
                        $input = readline("$playerName's turn. $playerName has: $playerHand. 'draw' or 'stop'?... ");
                        if ($input == 'draw') {
                            $this->draw($player);
                        } elseif ($input == 'stop') {
                            $this->compare($player);
                        } else {
                            continue;
                        }
                    } else {
                        if ($this->playerCount == 1) {
                            echo 'Dealer won!';
                            $this->showResults();
                        }
                        continue;
                    }
                } else {
                    if ($this->playerCount == 1) {
                        echo PHP_EOL . 'Dealer has won!' . PHP_EOL;
                        die();
                    } elseif ($this->getScore($player) >= 18) {
                        echo $player->showHand() . PHP_EOL;
                        echo $this->getScore($player);
                    } else {
                        echo $player->showHand() . PHP_EOL;
                        $this->draw($player);
                        if ($player->lost) {
                            echo PHP_EOL . 'Dealer has lost!';
                            $this->showResults();
                        }
                    }
                }
            }
        }
    }
}
