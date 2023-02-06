<?php

	function SystemLoader($className) {
	
		if(file_exists('./application/system/'.$className.'.php')) {
			require_once('./application/system/'.$className.'.php');
		} else {
			require_once('./application/modules/'.$className.'.php');
		}

    }
	
	spl_autoload_register('SystemLoader');

?>