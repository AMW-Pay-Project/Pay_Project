<?php
	
	$cards = '';
	
	foreach($sessionUser->getCards() as $card) {
		$tempArray = array();
		
		$tempArray['{cardType}'] = $card->getCardType();
		$tempArray['{cardNumber}'] = substr($card->getCardNumber(), -4);
		
		$cards .= $view->parseFile("user_home_cards", $tempArray);
	}
	
	$transactions = array(array());
	$tempNumber = 0;
	
	foreach($sessionUser->getTransactions() as $transaction) {
		if($tempNumber == 3) {
			break;
		}
		
		if($transaction->getSenderId() == $transaction->getReceiverId()) {
			$transactions[$tempNumber]['name'] = $sessionUser->getName() . ' ' . $sessionUser->getSurname();
			$transactions[$tempNumber]['amount'] = '+' . $transaction->getAmount() . ' PLN';
		} else {
			if($transaction->getReceiverId() == $sessionUser->getId()) {
				$senderUser = new User($transaction->getSenderId());
				
				$transactions[$tempNumber]['name'] = $senderUser->getName() . ' ' . $senderUser->getSurname();
				$transactions[$tempNumber]['amount'] = '+' . $transaction->getAmount() . ' PLN';
			} else {
				$receiverUser = new User($transaction->getReceiverId());
				
				$transactions[$tempNumber]['name'] = $receiverUser->getName() . ' ' . $receiverUser->getSurname();
				$transactions[$tempNumber]['amount'] = '-' . $transaction->getAmount() . ' PLN';
			}
		}
		
		$transactions[$tempNumber]['date'] = $transaction->getDate();
		
		$tempNumber++;
	}
	
	$demands = '';
	
	foreach($sessionUser->getDemands() as $demand) {
		$tempArray = array();
		$demandUser = new User($demand->getSenderId());
		
		$tempArray['{demand_name}'] = $demandUser->getName();
		$tempArray['{demand_surname}'] = $demandUser->getSurname();
		$tempArray['{demand_date}'] = $demand->getDate();
		$tempArray['{demand_amount}'] = $demand->getAmount();
		$tempArray['{demand_id}'] = $demand->getId();
		
		$demands = $view->parseFile("user_home_demands", $tempArray);
		
		break;
	}
	
	$view->load("user_home");
	$view->add("user_name", $sessionUser->getName());
	$view->add("user_surname", $sessionUser->getSurname());
	$view->add("account_balance", $sessionUser->getWallet()->getAccountBalance());
	$view->add("cards", $cards);
	$view->add("transactionOneName", $transactions[0]['name']);
	$view->add("transactionTwoName", $transactions[1]['name']);
	$view->add("transactionThreeName", $transactions[2]['name']);	
	$view->add("transactionOneAmount", $transactions[0]['amount']);
	$view->add("transactionTwoAmount", $transactions[1]['amount']);
	$view->add("transactionThreeAmount", $transactions[2]['amount']);	
	$view->add("transactionOneDate", $transactions[0]['date']);
	$view->add("transactionTwoDate", $transactions[1]['date']);
	$view->add("transactionThreeDate", $transactions[2]['date']);
	$view->add("demands", $demands);
	$view->out();
	
?>