<?php

require_once 'Card.php';
require_once 'Deck.php';
require_once 'Player.php';
require_once 'Blackjack.php';
require_once 'Dealer.php';

$dealer = new Dealer(new Blackjack(), new Deck());
$dealer->addPlayer(new Player('Ischa'));
$dealer->addPlayer(new Player('Merel'));
$dealer->playGame();