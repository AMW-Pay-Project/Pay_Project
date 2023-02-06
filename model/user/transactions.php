<?php

	$transactions = '';

	foreach($sessionUser->getTransactions() as $transaction) {
		$tempArray = array();
		
		if($transaction->getSenderId() == $transaction->getReceiverId()) {
			$tempArray['{name}'] = $sessionUser->getName();
			$tempArray['{surname}'] = $sessionUser->getSurname();
			$tempArray['{date}'] = $transaction->getDate();
			$tempArray['{amount}'] = $transaction->getAmount();
			$tempArray['{info}'] = 'Doładowanano konto';
			
			$transactions .= $view->parseFile("transaction_history_green", $tempArray);
		} else {
			if($transaction->getReceiverId() == $sessionUser->getId()) {
				$senderUser = new User($transaction->getSenderId());
				
				$tempArray['{name}'] = $senderUser->getName();
				$tempArray['{surname}'] = $senderUser->getSurname();
				$tempArray['{date}'] = $transaction->getDate();
				$tempArray['{amount}'] = $transaction->getAmount();
				$tempArray['{info}'] = 'Przelew przychodzący';
			
				$transactions .= $view->parseFile("transaction_history_green", $tempArray);
			} else {
				$receiverUser = new User($transaction->getReceiverId());
				
				$tempArray['{name}'] = $receiverUser->getName();
				$tempArray['{surname}'] = $receiverUser->getSurname();
				$tempArray['{date}'] = $transaction->getDate();
				$tempArray['{amount}'] = $transaction->getAmount();
				$tempArray['{info}'] = 'Przelew wychodzący';
			
				$transactions .= $view->parseFile("transaction_history_red", $tempArray);
			}
		}
	}

	$view->load("transaction_history");
	$view->add("user_name", $sessionUser->getName());
	$view->add("user_surname", $sessionUser->getSurname());
	$view->add("transactions", $transactions);
	$view->out();

?>