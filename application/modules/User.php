<?php

	class User {
		private int $id;
		private string $email;
		private string $password;
		private string $name;
		private string $surname;
		private string $birthday;
		private string $billingAddress;
		private string $postcode;
		private string $city;
		private int $isActive;
		private string $activationCode;
		
		private $wallet;
		private $cards = array();
		private $transactions = array();
		private $demands = array();
		
		function __construct($user) {
			if(is_numeric($user)) {
				$this->loadUserFromId($user);
			} else {
				$this->loadUserFromEmail($user);
			}
		}
		
		private function loadUserFromId(int $userId) {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `users` WHERE `id`=:userId LIMIT 1");
				$query->bindValue(":userId", $userId, PDO::PARAM_INT);
			$query->execute();
			
			if($query->rowCount() > 0) {
				$this->prepareUser($query->fetch());
			} else {
				$this->id = -1;
			}
		}
		
		private function loadUserFromEmail(string $userEmail) {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `users` WHERE `email`=:userEmail LIMIT 1");
				$query->bindValue(":userEmail", $userEmail, PDO::PARAM_STR);
			$query->execute();
			
			if($query->rowCount() > 0) {
				$this->prepareUser($query->fetch());
			} else {
				$this->id = -1;
			}
		}
		
		public static function newUser(string $mail, string $pass, string $name, string $surname, string $birthday, string $address, string $postcode, string $city, string $randomString) {
			$query = $GLOBALS['database']->prepare("INSERT INTO `users` VALUES(NULL, :mail, :pass, :name, :surname, :birthday, :address, :postcode, :city, 0, :activation);");
				$query->bindValue(":mail", $mail, PDO::PARAM_STR);
				$query->bindValue(":pass", $pass, PDO::PARAM_STR);
				$query->bindValue(":name", $name, PDO::PARAM_STR);
				$query->bindValue(":surname", $surname, PDO::PARAM_STR);
				$query->bindValue(":birthday", $birthday, PDO::PARAM_STR);
				$query->bindValue(":address", $address, PDO::PARAM_STR);
				$query->bindValue(":postcode", $postcode, PDO::PARAM_STR);
				$query->bindValue(":city", $city, PDO::PARAM_STR);
				$query->bindValue(":activation", $randomString, PDO::PARAM_STR);
			$query->execute();
			
			$query = $GLOBALS['database']->prepare("INSERT INTO `wallet` VALUES(NULL, :userId, 0)");
				$query->bindValue(":userId", $GLOBALS['database']->lastInsertId(), PDO::PARAM_INT);
			$query->execute();
		}
		
		private function prepareUser(array $fetch) {
			$this->id = $fetch['id'];
			$this->email = $fetch['email'];
			$this->password = $fetch['password'];
			$this->name = $fetch['name'];
			$this->surname = $fetch['surname'];
			$this->birthday = $fetch['birthday'];
			$this->billingAddress = $fetch['billing_address'];
			$this->postcode = $fetch['postcode'];
			$this->city = $fetch['city'];
			$this->isActive = $fetch['isActive'];
			$this->activationCode = $fetch['activation_code'];
			
			$this->wallet = new Wallet($this->id);
			$this->prepareCards();
			$this->prepareTransactions();
			$this->prepareDemands();
		}
		
		private function prepareCards() {
			$query = $GLOBALS['database']->prepare("SELECT `id` FROM `cards` WHERE `userId`=:userId");
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
			
			while($fetch = $query->fetch()) {
				$this->cards[$fetch['id']] = new Card($fetch['id']);
			}
		}
		
		private function prepareTransactions() {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `transactions` WHERE `senderId`=:userId OR `receiverId`=:userId ORDER BY `id` DESC");
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
			
			while($fetch = $query->fetch()) {
				$this->transactions[$fetch['id']] = new Transaction($fetch['id']);
			}
		}
		
		private function prepareDemands() {
			$query = $GLOBALS['database']->prepare("SELECT * FROM `demands` WHERE `receiverId`=:userId ORDER BY `id` ASC");
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
			
			while($fetch = $query->fetch()) {
				$this->demands[$fetch['id']] = new Demand($fetch['id']);
			}
		}
		
		public function getId() : int {
			return $this->id;
		}
		
		public function getEmail() : string {
			return $this->email;
		}
		
		public function setEmail(string $newEmail) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `email`=:newEmail WHERE `id`=:userId");
				$query->bindValue(":newEmail", $newEmail, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getPassword() : string {
			return $this->password;
		}
		
		public function setPassword(string $newPassword) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `password`=:newPassword WHERE `id`=:userId");
				$query->bindValue(":newPassword", $newPassword, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getName() : string {
			return $this->name;
		}
		
		public function setName(string $newName) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `name`=:newName WHERE `id`=:userId");
				$query->bindValue(":newName", $newName, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getSurname() : string {
			return $this->surname;
		}
		
		public function setSurname(string $newSurname) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `surname`=:newSurname WHERE `id`=:userId");
				$query->bindValue(":newSurname", $newSurname, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getBirthday() : string {
			return $this->birthday;
		}
		
		public function setBirthday(string $newBirthday) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `birthday`=:newBirthday WHERE `id`=:userId");
				$query->bindValue(":newBirthday", $newBirthday, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getbillingAddress() : string {
			return $this->billingAddress;
		}
		
		public function setBillingAddress(string $newBillingAddress) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `billing_address`=:newBillingAddress WHERE `id`=:userId");
				$query->bindValue(":newBillingAddress", $newBillingAddress, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getPostcode() : string {
			return $this->postcode;
		}
		
		public function setPostcode(string $newPostcode) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `postcode`=:newPostcode WHERE `id`=:userId");
				$query->bindValue(":newPostcode", $newPostcode, PDO::PARAM_STR);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getCity() : string {
			return $this->city;
		}
		
		public function setCity(string $newCity) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `city`=:newCity WHERE `id`=:userId");
				$query->bindValue(":newCity", $newCity, PDO::PARAM_STR);
				$query->bindValue("userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getIsActive() : int {
			return $this->isActive;
		}
		
		public function setIsActive(int $newIsActive) {
			$query = $GLOBALS['database']->prepare("UPDATE `users` SET `isActive`=:newIsActive WHERE `id`=:userId");
				$query->bindValue(":newIsActive", $newIsActive, PDO::PARAM_INT);
				$query->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$query->execute();
		}
		
		public function getActivationCode() : string {
			return $this->activationCode;
		}
		
		public function getWallet(){
			return $this->wallet;
		}
		
		public function getCards() {
			return $this->cards;
		}
		
		public function getTransactions() {
			return $this->transactions;
		}
		
		public function getDemands() {
			return $this->demands;
		}
	}
	
?>