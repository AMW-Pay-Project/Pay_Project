<?php

	if(isset($_POST['sendForm'])) {
		$email = $core->clearText($_POST['email']);
		(float) $amount = $core->clearText($_POST['amount']);
		$amount = round($amount, 2);
		
		$user = new User($email);
		
		if($user->getId() != -1) {
			
			if($user->getId() != $sessionUser->getId()) {
			
				Demand::newDemand(
					$sessionUser->getId(),
					$user->getId(),
					$amount
				);
				
				$message = "Masz nowe żądanie na swoim koncie!<br> Zaloguj się na swoim koncie aby je zaakceptować bądź odrzucić.";
				
				$core->sendMail($email, "AMW PP :: Żądanie", $message);
			
				$view->load('info');
					$view->add('title', ' Żądanie wysłane');
					$view->add('header', 'Żądanie wysłane!');
					$view->add('info', 'Żądanie zostało wysłane!');
					$view->add('back', 'index.php?page=demand_money');
				$view->out();
			
			} else {
				$view->load('info');
					$view->add('title', ' Żądanie nie wysłane');
					$view->add('header', 'Żądanie nie wysłane!');
					$view->add('info', 'Nie można żądać pieniędzy od samego siebie!');
					$view->add('back', 'index.php?page=demand_money');
				$view->out();
			}
		} else {
			$view->load('info');
				$view->add('title', ' Brak użytkownika');
				$view->add('header', 'Brak użytkownika!');
				$view->add('info', 'Taki użytkownik nie istnieje!');
				$view->add('back', 'index.php?page=demand_money');
			$view->out();
		}
	} else {
		$view->load("demand_money");
		$view->add("user_name", $sessionUser->getName());
		$view->add("user_surname", $sessionUser->getSurname());
		$view->out();
	}

?>