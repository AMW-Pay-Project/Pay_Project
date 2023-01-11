<?php

	if($_POST['sendSettingsForm']) {
		$name = $core->clearText($_POST['name']);
		$surname = $core->clearText($_POST['surname']);
		$birthday = $core->clearText($_POST['birthday']);
		$billing_address = $core->clearText($_POST['billing_address']);
		$postcode = $core->clearText($_POST['postcode']);
		$city = $core->clearText($_POST['city']);
		$email = $core->clearText($_POST['email']);
		
		$query = $database->prepare("UPDATE `users` SET `name`=:name, `surname`=:surname, `birthday`=:birthday, `billing_address`=:billing_address, `postcode`=:postcode, `city`=:city, `email`=:email WHERE `id`=:one");
			$query->bindValue(":one", $_SESSION['userId'], PDO::PARAM_INT);
			$query->bindValue(":name", $name, PDO::PARAM_STR);
			$query->bindValue(":surname", $surname, PDO::PARAM_STR);
			$query->bindValue(":birthday", $birthday, PDO::PARAM_STR);
			$query->bindValue(":billing_address", $billing_address, PDO::PARAM_STR);
			$query->bindValue(":postcode", $postcode, PDO::PARAM_STR);
			$query->bindValue(":city", $city, PDO::PARAM_STR);
			$query->bindValue(":email", $email, PDO::PARAM_STR);
		$query->execute();
		
		$view->load('info');
			$view->add('title', ' Dane zostały zmienione!');
			$view->add('header', 'Dane zostały zmienione!');
			$view->add('info', 'Dane zostały pomyślnie zmienione!');
			$view->add('back', 'index.php?page=settings');
		$view->out();

	} else {
		$query = $database->prepare("SELECT * FROM `users` WHERE `id`=:one");
			$query->bindValue(":one", $_SESSION['userId'], PDO::PARAM_INT);
		$query->execute();
		
		$fetch = $query->fetch();
		
		$view->load("settings");
		$view->add("name", $fetch['name']);
		$view->add("surname", $fetch['surname']);
		$view->add("birthday", $fetch['birthday']);
		$view->add("billing_address", $fetch['billing_address']);
		$view->add("postcode", $fetch['postcode']);
		$view->add("city", $fetch['city']);
		$view->add("email", $fetch['email']);
		$view->out();
	
		
	}
	
?>