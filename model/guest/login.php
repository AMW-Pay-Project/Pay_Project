<?php

	if(isset($_POST['sendLoginForm'])) {
		$mail = $core->clearText($_POST['email']);
		$pass = sha1(md5($core->clearText($_POST['password'])));
	
		$user = new User($mail);
		
		if($user->getId() != -1 && $user->getPassword() == $pass) {
			if($user->getIsActive() == 1) {
				$_SESSION['userId'] = $user->getId();
				$_SESSION['logged'] = true;
				
				header("Location: index.php?page=home");
			} else {
				$view->load('info');
				$view->add('title', ' Konto nieaktywne');
				$view->add('header', 'Konto jest nie aktywne!');
				$view->add('info', 'Twoje konto jest nieaktywne!');
				$view->add('back', 'index.php?page=login');
				$view->out();
			}
		} else {
			$view->load('info');
			$view->add('title', ' Błąd logowania');
			$view->add('header', 'Błąd logowania!');
			$view->add('info', 'Nieprawidłowe hasło albo twoje konto nie istnieje!');
			$view->add('back', 'index.php?page=login');
			$view->out();
		}
	} else {
		$view->load("login");
		$view->out();
	}

?>