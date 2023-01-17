<?php

	error_reporting(1);

	ob_start();
	
		session_start();
		
		require_once('./config.php');
		
		$database = new PDO('mysql:host='.$databaseHost.'; dbname='.$databaseName.'; charset=utf8;',  $databaseUser,  $databasePass);
		
		require_once('./application/SystemLoader.php');
		
		$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		$database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		$core = new Core();
		$view = new View();
		
		$page = $core->clearText($_GET['page']);
		$page = str_replace('/', '', $page);

		if(!$page || $page == '') { $page = 'home'; }
		
		$sessionStatus = $_SESSION['logged'] <> true ? 'guest':'user';
		
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