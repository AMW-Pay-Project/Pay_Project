<?php

	if($_POST['sendRegisterForm']) {
		$mail = $core->clearText($_POST['email']);
		
		$query = $database->prepare("SELECT `email` FROM `users` WHERE `email`=:mail LIMIT 1");
		$query->bindValue("mail", $mail, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
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
				
					$query = $database->prepare("INSERT INTO `users` VALUES(NULL, :mail, :pass, :name, :surname, :birthday, :address, :postcode, :city, 0, :activation);");
						$query->bindValue(":mail", $mail, PDO::PARAM_STR);
						$query->bindValue(":pass", sha1(md5($pass)), PDO::PARAM_STR);
						$query->bindValue(":name", $core->clearText($_POST['name']), PDO::PARAM_STR);
						$query->bindValue(":surname", $core->clearText($_POST['surname']), PDO::PARAM_STR);
						$query->bindValue(":birthday", $core->clearText($_POST['birthday']), PDO::PARAM_STR);
						$query->bindValue(":address", $core->clearText($_POST['address']), PDO::PARAM_STR);
						$query->bindValue(":postcode", $core->clearText($_POST['postcode']), PDO::PARAM_STR);
						$query->bindValue(":city", $core->clearText($_POST['city']), PDO::PARAM_STR);
						$query->bindValue(":activation", $randomString, PDO::PARAM_STR);
					$query->execute();
				
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