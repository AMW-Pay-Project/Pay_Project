<?php
	
	$cards = '';
	
	foreach($sessionUser->getCards() as $card) {
		$tempArray = array();
		$tempArray['{cardType}'] = $card->getCardType();
		$tempArray['{cardNumber}'] = substr($card->getCardNumber(), -4);
		$tempArray['{cardId}'] = $card->getId();
		
		$cards .= $view->parseFile("wallet_cards", $tempArray);
	}
	
	$view->load("wallet");
	$view->add("user_name", $sessionUser->getName());
	$view->add("user_surname", $sessionUser->getSurname());
	$view->add("account_balance", $sessionUser->getWallet()->getAccountBalance());
	$view->add("account_balance_usd", round($sessionUser->getWallet()->getAccountBalance() / $core->getExchangeRatesFromNbp("USD"), 2));
	$view->add("account_balance_euro", round($sessionUser->getWallet()->getAccountBalance() / $core->getExchangeRatesFromNbp("EUR"), 2));
	$view->add("cards", $cards);
	$view->out();
	
?>