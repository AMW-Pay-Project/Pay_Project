<?php

	$mail = $core->clearText($_GET['MAIL']);

	$user = new User($mail);
	
	if($user->getId() != -1) {
		$code = $core->clearText($_GET['CODE']);
	
		if($user->getActivationCode() == $code) {
			$user->setIsActive(1);
			
			$view->load('info');
				$view->add('title', ' Konto aktywne');
				$view->add('header', 'Konto aktywne!');
				$view->add('info', 'Konto zostało poprawnie aktywowane!');
				$view->add('back', 'index.php?page=login');
			$view->out();
		} else {
			$view->load('info');
				$view->add('title', ' Błąd aktywacji');
				$view->add('header', 'Błąd aktywacji!');
				$view->add('info', 'Kod aktywacyjny jest niepoprawny!');
				$view->add('back', 'index.php?page=login');
			$view->out();
		}
	} else {
		header("Location: index.php?page=home");
	}

?>