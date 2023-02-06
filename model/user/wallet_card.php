<?php

	$cardId = $core->clearText($_GET['id']);
	
	if(is_numeric($cardId)) {
		
		if(array_key_exists($cardId, $sessionUser->getCards())) {	
			$cards = '';
			
			foreach($sessionUser->getCards() as $card) {
				$tempArray = array();
				$tempArray['{cardType}'] = $card->getCardType();
				$tempArray['{cardNumber}'] = substr($card->getCardNumber(), -4);
				$tempArray['{cardId}'] = $card->getId();
		
				$cards .= $view->parseFile("wallet_cards", $tempArray);
			}
	
			$view->load("wallet_card");
			$view->add("user_name", $sessionUser->getName());
			$view->add("user_surname", $sessionUser->getSurname());
			$view->add("account_balance", $sessionUser->getWallet()->getAccountBalance());
			$view->add("cards", $cards);
			$view->add("cardType", $sessionUser->getCards()[$cardId]->getCardType());
			$view->add("cardNumber", substr($sessionUser->getCards()[$cardId]->getCardNumber(), -4));
			$view->add("billingAddress", $sessionUser->getBillingAddress());
			$view->add("postcode", $sessionUser->getPostcode());
			$view->add("city", $sessionUser->getCity());
			$view->add("cardExpiration", $sessionUser->getCards()[$cardId]->getCardExpiration());
			$view->add("cardId", $cardId);
			$view->out();
	
		} else {
			header("Location: index.php?page=wallet");
		}
	} else {
		header("Location: index.php?page=wallet");
	}

?>