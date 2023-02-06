<?php

	$cardId = $core->clearText($_GET['id']);
	
	if(is_numeric($cardId)) {
		$card = new Card($cardId);
		
		if($card->getId() != -1) {
			$card->deleteCard();
			
			$view->load('info');
				$view->add('title', ' Karta usunięta');
				$view->add('header', 'Karta usunięta');
				$view->add('info', 'Karta została poprawnie usunięta!');
				$view->add('back', 'index.php?page=wallet');
			$view->out();
			
		} else {
			header("Location: index.php?page=wallet");
		}
	} else {
		header("Location: index.php?page=wallet");
	}

?>