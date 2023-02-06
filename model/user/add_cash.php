<?php

	if(isset($_POST['sendForm'])) {
		$cardId = $core->clearText($_POST['cardId']);
		(float) $amount = $core->clearText($_POST['amount']);
		$amount = round($amount, 2);
		
		$acceptableCard = new AcceptableCard($cardId);
		
		if($acceptableCard->getBalance() >= $amount && $amount > 0) {
			$acceptableCard->setBalance(
				$acceptableCard->getBalance() - $amount
			);
			
			$sessionUser->getWallet()->setAccountBalance(
				$sessionUser->getWallet()->getAccountBalance() + $amount
			);
			
			Transaction::newTransaction($sessionUser->getId(), $sessionUser->getId(), $amount);
			
			$view->load('info');
				$view->add('title', ' Konto doładowane');
				$view->add('header', 'Konto doładowane!');
				$view->add('info', 'Konto zostało doładowane!');
				$view->add('back', 'index.php?page=add_cash');
			$view->out();
		} else {
			$view->load('info');
				$view->add('title', ' Brak środków');
				$view->add('header', 'Brak środków!');
				$view->add('info', 'Na karcie nie ma wymaganej ilości środków!');
				$view->add('back', 'index.php?page=add_cash');
			$view->out();
		}		
		
	} else {
		
		if(count($sessionUser->getCards()) > 0) {
		
			$options = '';
			
			foreach($sessionUser->getCards() as $card) {
				$options .= '<option value="'.$card->getAcNumber().'">Karta '.$card->getCardType().' ***'.substr($card->getCardNumber(), -4).'</option>';
			}

			$view->load("add_cash");
				$view->add("user_name", $sessionUser->getName());
				$view->add("user_surname", $sessionUser->getSurname());
				$view->add("cards", $options);
			$view->out();
		
		} else {
			$view->load('info');
				$view->add('title', ' Brak kart');
				$view->add('header', 'Brak kart!');
				$view->add('info', 'Niestety nie posiadasz żadnych kart dzięki którym mógłbyś doładować konto!');
				$view->add('back', 'index.php?page=wallet');
			$view->out();
		}
	
	}

?>