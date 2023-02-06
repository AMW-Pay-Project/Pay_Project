<?php

	if($_POST['sendForm']) {
		$oldPassword = $core->clearText($_POST['oldPassword']);
		$newPassword = $core->clearText($_POST['newPassword']);
		$newPasswordRepeat = $core->clearText($_POST['newPasswordRepeat']);
		
		if($sessionUser->getPassword() == sha1(md5($oldPassword))) {
			if($newPassword == $newPasswordRepeat) {
				if(preg_match("#.*^(?=.{10,32})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $newPassword)) {
					$sessionUser->setPassword(sha1(md5($newPassword)));
					
					$view->load('info');
						$view->add('title', ' Hasło zmienione');
						$view->add('header', 'Hasło zmienione!');
						$view->add('info', 'Hasło zostało poprawnie zmienione!');
						$view->add('back', 'index.php?page=change_password');
					$view->out();
				} else {
					$view->load('info');
						$view->add('title', ' Błąd zmiany hasła');
						$view->add('header', 'Błąd zmiany hasła!');
						$view->add('info', 'Hasło musi mieć od 10 do 32 znaków, małą i dużą literę oraz znak specjalny!');
						$view->add('back', 'index.php?page=change_password');
					$view->out();
				}
			} else {
				$view->load('info');
					$view->add('title', ' Błąd zmiany hasła');
					$view->add('header', 'Błąd zmiany hasła!');
					$view->add('info', 'Hasła muszą być takie same!');
					$view->add('back', 'index.php?page=change_password');
				$view->out();
			}
		} else {
			$view->load('info');
				$view->add('title', ' Błąd zmiany hasła');
				$view->add('header', 'Błąd zmiany hasła!');
				$view->add('info', 'Stare hasło jest błędne!');
				$view->add('back', 'index.php?page=change_password');
			$view->out();
		}
	} else {
		$view->load("change_password");
		$view->out();
	}

?>