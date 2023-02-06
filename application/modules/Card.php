<?php

	class Card {
		private int $id;
		private int $userId;
		private int $cardNumber;
		private string $cardType;
		private string $cardExpiration;
		private int $cardCvc;
		private int $acNumber;
		
		public function __construct(int $cardId) {
			$this->loadCard($cardId);
		}
		
		private function loadCard(int $cardId) {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `cards` WHERE `id`=:cardId");
				$query->bindValue(":cardId", $cardId, PDO::PARAM_INT);
			$query->execute();
			
			if($query->rowCount() > 0) {
				$fetch = $query->fetch();
			
				$this->id = $fetch['id'];
				$this->userId = $fetch['userId'];
				$this->cardNumber = $fetch['cardNumber'];
				$this->cardType = $fetch['cardType'];
				$this->cardExpiration = $fetch['cardExpiration'];
				$this->cardCvc = $fetch['cardCvc'];
				$this->acNumber = $fetch['acNumber'];
			} else {
				$this->id = -1;
			}
		}
		
		public static function addCard(int $userId, int $cardNumber, string $cardType, string $cardExpiration, int $cardCvc, int $acNumber) {
			$query = $GLOBALS['database']->prepare("INSERT INTO `cards` VALUES(NULL, :userId, :cardNumber, :cardType, :cardExpiration, :cardCvc, :acNumber)");
				$query->bindValue(":userId", $userId, PDO::PARAM_INT);
				$query->bindValue(":cardNumber", $cardNumber, PDO::PARAM_INT);
				$query->bindValue(":cardType", $cardType, PDO::PARAM_STR);
				$query->bindValue(":cardExpiration", $cardExpiration, PDO::PARAM_STR);
				$query->bindValue(":cardCvc", $cardCvc, PDO::PARAM_INT);
				$query->bindValue(":acNumber", $acNumber, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getId() : int {
			return $this->id;
		}
		
		public function getUserId() : int {
			return $this->userId;
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
		
		public function getAcNumber() : int {
			return $this->acNumber;
		}
		
		public function deleteCard() {
			$query = $GLOBALS['database']->prepare("DELETE FROM `cards` WHERE `id`=:cardId");
				$query->bindValue(":cardId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
	}