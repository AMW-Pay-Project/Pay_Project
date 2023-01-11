<?php

	if($_POST['sendLoginForm']) {
		$mail = $core->clearText($_POST['email']);
		$pass = sha1(md5($core->clearText($_POST['password'])));
	
		$query = $database->prepare("SELECT * FROM `users` WHERE `email`=:mail AND `password`=:pass LIMIT 1");
		$query->bindValue(":mail", $mail, PDO::PARAM_STR);
		$query->bindValue(":pass", $pass, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$fetch = $query->fetch();
			
			if($fetch['isActive'] == 1) {
				$_SESSION['userId'] = $fetch['id'];
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