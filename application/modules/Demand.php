<?php

	class Demand {
		private $id;
		private $date;
		private $senderId;
		private $receiverId;
		private $amount;
		
		public function __construct(int $id) {
			$this->loadTransaction($id);
		}
		
		private function loadTransaction(int $id) {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `demands` WHERE `id`=:id");
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
		
		public static function newDemand(int $senderId, int $receiverId, float $amount) {
			$query = $GLOBALS['database']->prepare("INSERT INTO `demands` VALUES(NULL, CURRENT_TIMESTAMP, :senderId, :receiverId, :amount)");
				$query->bindValue(":senderId", $senderId, PDO::PARAM_INT);
				$query->bindValue(":receiverId", $receiverId, PDO::PARAM_INT);
				$query->bindValue(":amount", $amount, PDO::PARAM_STR);
			$query->execute();
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
		
		public function deleteDemand() {
			$query = $GLOBALS['database']->prepare("DELETE FROM `demands` WHERE `id`=:id");
				$query->bindValue(":id", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
	}

?>