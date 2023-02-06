<?php

	if(isset($_POST['sendRegisterForm'])) {
		$mail = $core->clearText($_POST['email']);
		
		$user = new User($mail);
		
		if($user->getId() != -1) {
			$view->load('info');
				$view->add('title', ' Błąd rejestracji');
				$view->add('header', 'Błąd rejestracji!');
				$view->add('info', 'Taki adres e-mail istnieje już w naszej bazie danych!');
				$view->add('back', 'index.php?page=register');
			$view->out();
		} else {
			$pass = $core->clearText($_POST['pass']);
			$passRepeat = $core->clearText($_POST['passrepeat']);
			
			if($pass == $passRepeat) {
				if(preg_match("#.*^(?=.{10,32})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $pass)) {
					$randomString = $core->randomString(10);
					
					User::newUser(
						$mail,
						sha1(md5($pass)),
						$core->clearText($_POST['name']),
						$core->clearText($_POST['surname']),
						$core->clearText($_POST['birthday']),
						$core->clearText($_POST['address']),
						$core->clearText($_POST['postcode']),
						$core->clearText($_POST['city']),
						$randomString
					);
				
					$message = "<b><a href=\"https://".$_SERVER['SERVER_NAME']."/index.php?page=activation&MAIL=".$mail."&CODE=".$randomString."\">Kliknij aby aktywowac konto</a></b>";
				
					$core->sendMail($mail, "AMW PP :: Rejestracja", $message);
				
					$view->load('info');
						$view->add('title', ' Rejestracja udana');
						$view->add('header', 'Rejestracja udana!');
						$view->add('info', 'Rejestracja przebiegła pomyślnie!<br>Wkrótce otrzymasz e-maila z linkiem aktywującym.<br>Pamiętaj aby sprawdzić również folder SPAM.');
						$view->add('back', 'index.php?page=login');
					$view->out();
				} else {
					$view->load('info');
						$view->add('title', ' Błąd rejestracji');
						$view->add('header', 'Błąd rejestracji!');
						$view->add('info', 'Hasło musi mieć od 10 do 32 znaków, małą i dużą literę oraz znak specjalny!');
						$view->add('back', 'index.php?page=register');
					$view->out();
				}
			} else {
				$view->load('info');
					$view->add('title', ' Błąd rejestracji');
					$view->add('header', 'Błąd rejestracji!');
					$view->add('info', 'Hasła muszą być takie same!');
					$view->add('back', 'index.php?page=register');
				$view->out();
			}
		}
	} else {
		$view->load("register");
		$view->out();
	}

?>