<?php

	if($_POST['sendRemindForm']) {
		$mail = $core->clearText($_POST['mail']);
		
		$query = $database->prepare("SELECT `activation_code` FROM `users` WHERE `email`=:mail LIMIT 1");
		$query->bindValue(":mail", $mail, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$fetch = $query->fetch();
			
			$subject = "Przypomnienie hasła";
         
			$message = "<b><a href=\"https://".$_SERVER['SERVER_NAME']."/index.php?page=remind_password&MAIL=".$mail."&CODE=".$fetch['activation_code']."\">Kliknij aby zresetowac haslo</a></b>";
         
			$core->sendMail($mail, "AMW PP :: Przypomnienie hasla", $message);
		}
		
		$view->load('info');
			$view->add('title', ' Przypomnienie hasła');
			$view->add('header', 'Przypomnienie hasła!');
			$view->add('info', 'Jeżeli taki email istnieje w naszej bazie danych w ciągu kilku minut powinieneś otrzymać dane do zmiany hasła');
			$view->add('back', 'index.php?page=login');
		$view->out();
	} else if($_GET['MAIL']) {
		$mail = $core->clearText($_GET['MAIL']);
		$code = $core->clearText($_GET['CODE']);
		
		$query = $database->prepare("SELECT `id`, `activation_code` FROM `users` WHERE `email`=:mail LIMIT 1");
		$query->bindValue("mail", $mail, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$fetch = $query->fetch();
			
			if($fetch['activation_code'] == $code) {
				$view->load("remind_password_new");
					$view->add("mail", $mail);
					$view->add("code", $code);
				$view->out();
			} else {
				$view->load('info');
					$view->add('title', ' Błędny kod');
					$view->add('header', 'Błędny kod!');
					$view->add('info', 'Podany kod weryfikacyjny jest błędny');
					$view->add('back', 'index.php?page=remind_password');
				$view->out();
			}
		}
	} else if($_POST['sendNewPass']) {
		$mail = $core->clearText($_POST['MAIL']);
		$code = $core->clearText($_POST['CODE']);
		
		$query = $database->prepare("SELECT `id`, `activation_code` FROM `users` WHERE `email`=:mail LIMIT 1");
		$query->bindValue("mail", $mail, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$fetch = $query->fetch();
			
			if($fetch['activation_code'] == $code) {
				$pass = $core->clearText($_POST['PASS']);
				$passrepeat = $core->clearText($_POST['PASSREPEAT']);
				
				if($pass == $passrepeat) {
					if(preg_match("#.*^(?=.{10,32})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $pass)) {
						$newQuery = $database->prepare("UPDATE `users` SET `password`=:pass WHERE `id`=:id");
						$newQuery->bindValue("pass", sha1(md5($pass)), PDO::PARAM_STR);
						$newQuery->bindValue("id", $fetch['id'], PDO::PARAM_INT);
						$newQuery->execute();
				
						$view->load('info');
							$view->add('title', ' Hasło zmienione');
							$view->add('header', 'Hasło zmienione!');
							$view->add('info', 'Hasło zostało zmienione poprawnie');
							$view->add('back', 'index.php?page=login');
						$view->out();
					} else {
						$view->load("remind_password_new_error");
							$view->add("mail", $mail);
							$view->add("code", $code);
							$view->add("error", "Hasło musi mieć od 10 do 32 znaków, małą i dużą literę oraz znak specjalny!");
						$view->out();
					}
				} else {
					$view->load("remind_password_new_error");
						$view->add("mail", $mail);
						$view->add("code", $code);
						$view->add("error", "Hasła muszą być takie same!");
					$view->out();
				}
			} else {
				$view->load("remind_password_new_error");
					$view->add("mail", $mail);
					$view->add("code", $code);
					$view->add("error", "Podany kod weryfikacyjny jest błędny!");
				$view->out();
			}
		}
		
	} else {
		$view->load("remind_password");
		$view->out();
	}

?>