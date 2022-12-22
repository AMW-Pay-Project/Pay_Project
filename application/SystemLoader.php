<?php

	function SystemLoader($className) {
	
		if(file_exists('./application/'.$className.'.php')) {
			require_once('./application/'.$className.'.php');
		}

    }
	
	spl_autoload_register('SystemLoader');

?>