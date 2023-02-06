<?php

	class Wallet {
		private int $id;
		private int $userId;
		private float $accountBalance;
		
		public function __construct(int $userId) {
			$this->loadWallet($userId);
		}
		
		private function loadWallet(int $userId) {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `wallet` WHERE `user_id`=:userId LIMIT 1");
				$query->bindValue(":userId", $userId, PDO::PARAM_INT);
			$query->execute();
			
			$fetch = $query->fetch();
			
			$this->id = $fetch['id'];
			$this->userId = $fetch['user_id'];
			$this->accountBalance = $fetch['account_balance'];
		}
		
		public function getId() : int {
			return $this->id;
		}
		
		public function getUserId() : int {
			return $this->userId;
		}
		
		public function getAccountBalance() : float {
			return $this->accountBalance;
		}
		
		public function setAccountBalance(float $newBalance) {
			$query = $GLOBALS['database']->prepare("UPDATE `wallet` SET `account_balance`=:newBalance WHERE `user_id`=:userId");
				$query->bindValue(":newBalance", $newBalance, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->userId, PDO::PARAM_INT);
			$query->execute();
		}
		
	}

?>