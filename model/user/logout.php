<?php

	$_SESSION['userId'] = null;
	$_SESSION['logged'] = null;
	
	header("Location: index.php?page=home");

?>