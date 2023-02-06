<?php

	ob_start();
	
		error_reporting(0);
	
		session_start();
		
		require_once('./config.php');
		
		$database = new PDO('mysql:host='.$databaseHost.'; dbname='.$databaseName.'; charset=utf8;',  $databaseUser,  $databasePass);
		
		require_once('./application/SystemLoader.php');
		
		$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		$database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		$core = new Core();
		$view = new View();
		
		$page = null;
		
		if(isset($_GET['page'])) {
			$page = $core->clearText($_GET['page']);
			$page = str_replace('/', '', $page);
		} else {
			$page = 'home'; 
		}
		
		$sessionStatus = null;
		$sessionUser = null;
		
		if(isset($_SESSION['logged']) && isset($_SESSION['userId'])) {
			$sessionStatus = 'user';
			$sessionUser = new User($_SESSION['userId']);
		} else {
			$sessionStatus = 'guest';
		}
		
		if(file_exists('./model/'.$sessionStatus.'/'.$page.'.php')) {
			require_once('./model/'.$sessionStatus.'/'.$page.'.php');
		} else {
			$view->load('info');
				$view->add('title', ' Błąd 404');
				$view->add('header', 'Błąd 404!');
				$view->add('info', 'Taka strona nie istnieje!');
				$view->add('back', 'index.php?page=home');
			$view->out();
		}
	
	ob_end_flush();

?>