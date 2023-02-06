<?php

	class AcceptableCard {
		private int $id;
		private int $cardNumber;
		private string $cardType;
		private string $cardExpiration;
		private int $cardCvc;
		private float $balance;
		
		public function __construct(int $cardId) {
			$this->loadData($cardId);
		}
		
		private function loadData(int $cardId) {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `acceptable_cards` WHERE `id`=:cardId");
				$query->bindValue(":cardId", $cardId, PDO::PARAM_INT);
			$query->execute();
			
			if($query->rowCount() > 0) {
				$fetch = $query->fetch();
				
				$this->id = $fetch['id'];
				$this->cardNumber = $fetch['cardNumber'];
				$this->cardType = $fetch['cardType'];
				$this->cardExpiration = $fetch['cardExpiration'];
				$this->cardCvc = $fetch['cardCvc'];
				$this->balance = $fetch['balance'];
			}
		}
		
		public function getId() : int {
			return $this->id;
		}
		
		public function getCardNumber() : int {
			return $this->cardNumber;
		}
		
		public function getCardType() : string {
			return $this->cardType;
		}
		
		public function getCardExpiration() : string {
			return $this->cardExpiration;
		}
		
		public function getCardCvc() : int {
			return $this->cardCvc;
		}
		
		public function getBalance() : float {
			return $this->balance;
		}
		
		public function setBalance(float $newBalance) {
			$query = $GLOBALS['database']->prepare("UPDATE `acceptable_cards` SET `balance`=:newBalance WHERE `id`=:cardId");
				$query->bindValue(":newBalance", $newBalance, PDO::PARAM_STR);
				$query->bindValue("cardId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public static function searchCard(int $cardNumber, string $cardType, string $cardExpiration, int $cardCvc) : int {
			$query = $GLOBALS['database']->prepare("SELECT `id` FROM `acceptable_cards` WHERE `cardNumber`=:cardNumber AND `cardType`=:cardType AND `cardExpiration`=:cardExpiration AND `cardCvc`=:cardCvc LIMIT 1");
				$query->bindValue(":cardNumber", $cardNumber, PDO::PARAM_INT);
				$query->bindValue(":cardType", $cardType, PDO::PARAM_STR);
				$query->bindValue(":cardExpiration", $cardExpiration, PDO::PARAM_STR);
				$query->bindValue(":cardCvc", $cardCvc, PDO::PARAM_INT);
			$query->execute();
			
			if($query->rowCount() > 0) {
				$fetch = $query->fetch();
				
				return $fetch['id'];
			} else {
				return -1;
			}
		}
	}

?>