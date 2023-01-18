<?php

	$mail = $core->clearText($_GET['MAIL']);

	$query = $database->prepare("SELECT `id`, `activation_code` FROM `users` WHERE `email`=:mail LIMIT 1");
	$query->bindValue("mail", $mail, PDO::PARAM_STR);
	$query->execute();
	
	if($query->rowCount() > 0) {
		$fetch = $query->fetch();
		$code = $core->clearText($_GET['CODE']);
	
		if($fetch['activation_code'] == $code) {
			$query = $database->prepare("UPDATE `users` SET `isActive`=1 WHERE `id`=:one");
			$query->bindValue(":one", $fetch['id'], PDO::PARAM_INT);
			$query->execute();
			
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