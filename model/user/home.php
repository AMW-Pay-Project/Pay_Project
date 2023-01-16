<?php

	$query = $database->prepare("SELECT `name`, `surname` FROM `users` WHERE `id`=:one");
	$query->bindValue(":one", $_SESSION['userId'], PDO::PARAM_INT);
	$query->execute();

	$fetch = $query->fetch();
	
	$view->load("user_home");
	$view->add("user_name", $fetch['name']);
	$view->add("user_surname", $fetch['surname']);
	$view->out();
	
?>