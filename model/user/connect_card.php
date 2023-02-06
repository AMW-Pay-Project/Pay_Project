<?php

	if(isset($_POST['sendForm'])) {
		$cardNumber = $core->clearText($_POST['cardNumber']);
		$cardType = $core->clearText($_POST['cardType']);
		$cardExpiration = $core->clearText($_POST['cardExpiration']);
		$cardCvc = $core->clearText($_POST['cardCvc']);
		
		if(strlen($cardNumber) == 16) {
			if(strlen($cardExpiration) == 7) {
				if(strlen($cardCvc) == 3) {
					$cardId = AcceptableCard::searchCard($cardNumber, $cardType, $cardExpiration, $cardCvc);
					
					if($cardId != -1) {
						Card::addCard($sessionUser->getId(), $cardNumber, $cardType, $cardExpiration, $cardCvc, $cardId);
					
						$view->load('info');
							$view->add('title', ' Karta dodana');
							$view->add('header', 'Karta dodana!');
							$view->add('info', 'Karta została dodana poprawnie!');
							$view->add('back', 'index.php?page=wallet');
						$view->out();
					} else {
						$view->load('info');
							$view->add('title', ' Błąd dodawania karty');
							$view->add('header', 'Błąd dodawania karty!');
							$view->add('info', 'Taka karta nie istnieje!');
							$view->add('back', 'index.php?page=wallet');
						$view->out();
					}
					
				} else {
					$view->load('info');
						$view->add('title', ' Błąd dodawania karty');
						$view->add('header', 'Błąd dodawania karty!');
						$view->add('info', 'Numer CVC musi mieć 3 znaki!');
						$view->add('back', 'index.php?page=connect_card');
					$view->out();
				}
				
			} else {
				$view->load('info');
					$view->add('title', ' Błąd dodawania karty');
					$view->add('header', 'Błąd dodawania karty!');
					$view->add('info', 'Błędna data ważności karty!');
					$view->add('back', 'index.php?page=connect_card');
				$view->out();
			}
			
		} else {
			$view->load('info');
				$view->add('title', ' Błąd dodawania karty');
				$view->add('header', 'Błąd dodawania karty!');
				$view->add('info', 'Numer karty musi mieć 16 znaków!');
				$view->add('back', 'index.php?page=connect_card');
			$view->out();
		}
	} else {
		$view->load("connect_card");
		$view->out();
	}

?>