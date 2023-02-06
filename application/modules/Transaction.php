<?php

	class Transaction {
		private $id;
		private $date;
		private $senderId;
		private $receiverId;
		private $amount;
		
		public function __construct(int $id) {
			$this->loadTransaction($id);
		}
		
		public static function newTransaction(int $senderId, int $receiverId, float $amount) {
			$query = $GLOBALS['database']->prepare("INSERT INTO `transactions` VALUES(NULL, CURRENT_TIMESTAMP, :senderId, :receiverId, :amount)");
				$query->bindValue(":senderId", $senderId, PDO::PARAM_INT);
				$query->bindValue(":receiverId", $receiverId, PDO::PARAM_INT);
				$query->bindValue(":amount", $amount, PDO::PARAM_STR);
			$query->execute();
		}
		
		private function loadTransaction(int $id) {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `transactions` WHERE `id`=:id");
				$query->bindValue(":id", $id, PDO::PARAM_INT);
			$query->execute();
			
			if($query->rowCount() > 0) {
				$fetch = $query->fetch();
			
				$this->id = $fetch['id'];
				$this->date = $fetch['date'];
				$this->senderId = $fetch['senderId'];
				$this->receiverId = $fetch['receiverId'];
				$this->amount = $fetch['amount'];
			}
		}
		
		public function getId() : int {
			return $this->id;
		}
		
		public function getDate() : string {
			return $this->date;
		}
		
		public function getSenderId() : int {
			return $this->senderId;
		}
		
		public function getReceiverId() : int {
			return $this->receiverId;
		}
		
		public function getAmount() : int {
			return $this->amount;
		}
	}

?>