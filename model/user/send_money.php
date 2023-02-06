<?php

	if(isset($_POST['sendForm'])) {
		
		$email = $core->clearText($_POST['email']);
		(float) $amount = $core->clearText($_POST['amount']);
		$amount = round($amount, 2);
		
		$receiverUser = new User($email);
		
		if($receiverUser->getId() != -1) {
			if($sessionUser->getWallet()->getAccountBalance() >= $amount) {
				
				if($receiverUser->getId() != $sessionUser->getId()) {
					$sessionUser->getWallet()->setAccountBalance(
						$sessionUser->getWallet()->getAccountBalance() - $amount
					);
					
					$receiverUser->getWallet()->setAccountBalance(
						$receiverUser->getWallet()->getAccountBalance() + $amount
					);
				
					Transaction::newTransaction($sessionUser->getId(), $receiverUser->getId(), $amount);
				
					$view->load('info');
						$view->add('title', ' Pieniądze wysłane');
						$view->add('header', 'Pieniądze wysłane!');
						$view->add('info', 'Pieniądze zostały pomyślnie wysłane!');
						$view->add('back', 'index.php?page=wallet');
					$view->out();
				} else {
					$view->load('info');
						$view->add('title', ' Błędny użytkownik');
						$view->add('header', 'Błędny użytkownik!');
						$view->add('info', 'Nie można wysyłać przelewu do samego siebie!');
						$view->add('back', 'index.php?page=wallet');
					$view->out();
				}
			} else {
				$view->load('info');
					$view->add('title', ' Brak środków');
					$view->add('header', 'Brak środków!');
					$view->add('info', 'Nie posiadasz takiej ilości pieniędzy na swoim koncie!');
					$view->add('back', 'index.php?page=send_money');
				$view->out();
			}
			
		} else {
			$view->load('info');
				$view->add('title', ' Brak użytkownika');
				$view->add('header', 'Brak użytkownika!');
				$view->add('info', 'Taki użytkownik nie istnieje!');
				$view->add('back', 'index.php?page=send_money');
			$view->out();
		}
		
	} else {
		$view->load("sending_money");
		$view->add("user_name", $sessionUser->getName());
		$view->add("user_surname", $sessionUser->getSurname());
		$view->out();
	}

?>