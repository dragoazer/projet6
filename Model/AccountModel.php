<?php
	namespace Projet6\Model;

	use Projet6\Model\Manager;
	use Projet6\Entity\Account;

	/**
	 * 
	 */
	class AccountModel extends Manager
	{
		private $req;

		public function __construct()
		{
			$this->req = $this->dbConnect();
		}

		public function setRegistration (Account $account)
		{
			$exec = $this->req->prepare("SELECT pseudo, email FROM account WHERE email=? OR pseudo=?");
			$exec->execute(array(
				$account->email(),
				$account->pseudo(),
			));
			if ($exec->fetch()) {
				echo "error";
			} else {
				$exec = $this->req->prepare("INSERT INTO account(pseudo, user_type, profile_picture, email, pwd) VALUES (:pseudo, :user_type, :profile_picture, :email, :pwd)");
				try {
					$exec->execute([
			        	"pseudo"=> $account->pseudo(),
			        	"user_type"=>"member",
			        	"profile_picture" => "./img/profile/profile_picture.jpg",
			        	"email"=> $account->email(),
			        	"pwd"=> password_hash($account->pwd(), PASSWORD_DEFAULT),
			    	]);
				}
				catch (Exception $e) {
					echo "error";
				}
			}
		}

		public function verifyPwd (Account $account)
		{
			$exec = $this->req->prepare("SELECT pwd FROM account WHERE email=?");
			$exec->execute(array(
				$account->email(),
			));
			if ($exec->rowCount() > 0) {
				$data = $exec->fetch();
				return $data;
			} else {
				return "error";
			}
		}

		public function setLogin (Account $account)
		{
			$exec = $this->req->prepare("SELECT email, pseudo, user_type, profile_picture FROM account WHERE email=?");
			$exec->execute(array(
				$account->email(),
			));

			if ($exec->rowCount() > 0) {
				$data = new Account($exec->fetch());
				return $data;
			} else {
				return "error";
			}
		}

		public function modifyImgProfile (Account $account)
		{
			$exec = $this->req->prepare("UPDATE account SET profile_picture = :profile_picture WHERE pseudo = :pseudo");
			$exec->execute(array(
				'pseudo' => $account->pseudo(),
				'profile_picture' => $account->profile_picture()
			));
		}

		public function modifyPwd ( string $newPwd, string $email)
		{
			$exec = $this->req->prepare("UPDATE account SET pwd = :newPwd WHERE email = :email");
			$exec->execute(array(
				'newPwd' => password_hash($newPwd, PASSWORD_DEFAULT),
				'email' => $email
			));
		}
	}