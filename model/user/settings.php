<?php

	if(isset($_POST['sendSettingsForm'])) {
		$sessionUser->setName($core->clearText($_POST['name']));
		$sessionUser->setSurname($core->clearText($_POST['surname']));
		$sessionUser->setBirthday($core->clearText($_POST['birthday']));
		$sessionUser->setBillingAddress($core->clearText($_POST['billing_address']));
		$sessionUser->setPostcode($core->clearText($_POST['postcode']));
		$sessionUser->setCity($core->clearText($_POST['city']));
		$sessionUser->setEmail($core->clearText($_POST['email']));
		
		$view->load('info');
			$view->add('title', ' Dane zostały zmienione!');
			$view->add('header', 'Dane zostały zmienione!');
			$view->add('info', 'Dane zostały pomyślnie zmienione!');
			$view->add('back', 'index.php?page=settings');
		$view->out();

	} else {
		$view->load("settings");
		$view->add("name", $sessionUser->getName());
		$view->add("surname", $sessionUser->getSurname());
		$view->add("birthday", $sessionUser->getBirthday());
		$view->add("billing_address", $sessionUser->getBillingAddress());
		$view->add("postcode", $sessionUser->getPostcode());
		$view->add("city", $sessionUser->getCity());
		$view->add("email", $sessionUser->getEmail());
		$view->out();
	}
	
?>