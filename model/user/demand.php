<?php

	$action = $core->clearText($_GET['action']);
	$id = $core->clearText($_GET['id']);
	
	if(is_numeric($id)) {
		
		$demand = new Demand($id);
		
		if($demand->getReceiverId() == $sessionUser->getId()) {
			
			if($action == 'accept') {
				
				if($sessionUser->getWallet()->getAccountBalance() >= $demand->getAmount()) {
					$receiverUser = new User($demand->getSenderId());
					
					$sessionUser->getWallet()->setAccountBalance(
						$sessionUser->getWallet()->getAccountBalance() - $demand->getAmount()
					);
						
					
					$receiverUser->getWallet()->setAccountBalance(
						$receiverUser->getWallet()->getAccountBalance() + $demand->getAmount()
					);
					
					Transaction::newTransaction($demand->getReceiverId(), $demand->getSenderId(), $demand->getAmount());
					
					$demand->deleteDemand();
					
					$view->load('info');
						$view->add('title', ' Żądanie opłacone');
						$view->add('header', 'Żądanie opłacone');
						$view->add('info', 'Żądanie zostało pomyślnie opłacone!');
						$view->add('back', 'index.php?page=home');
					$view->out();
				} else {
					$view->load('info');
						$view->add('title', ' Brak żądanej kwoty');
						$view->add('header', 'Brak żądanej kwoty');
						$view->add('info', 'Niestety nie posiadasz odpowiedniej kwoty aby móc zaakceptować to żądanie!');
						$view->add('back', 'index.php?page=home');
					$view->out();
				}
			} else if($action == 'cancel') {
				$demand->deleteDemand();
				
				$view->load('info');
					$view->add('title', ' Żądanie anulowane');
					$view->add('header', 'Żądanie anulowane');
					$view->add('info', 'Żądanie zostało pomyślnie anulowane!');
					$view->add('back', 'index.php?page=home');
				$view->out();
			} else {
				header("Location: index.php?page=home");
			}
			
		} else {
			header("Location: index.php?page=home");
		}
		
	} else {
		header("Location: index.php?page=home");
	}

?>