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
			$exec = $this->req->prepare("SELECT first_name, last_name, email FROM account WHERE email=?");
			$exec->execute(array(
				$account->email(),
			));
			if ($exec->fetch()) {
				echo "error";
			} else {
				$exec = $this->req->prepare("INSERT INTO account(first_name, last_name, user_type, profile_picture, email, pwd) VALUES (:first_name, :last_name, :user_type, :profile_picture, :email, :pwd)");
				$exec->execute([
		        	"first_name"=> $account->first_name(),
		        	"last_name"=> $account->last_name(),
		        	"user_type"=>"member",
		        	"profile_picture" => ".\public\imgprofile_picture.jpg",
		        	"email"=> $account->email(),
		        	"pwd"=> password_hash($account->pwd(), PASSWORD_DEFAULT),
		    	]);
		    	echo "work";
			}
		}

		public function setLogin (Account $account)
		{
			$exec = $this->req->prepare("SELECT email, last_name, first_name, user_type FROM account WHERE email=?");
			$exec->execute(array(
				$account->email(),
			));

			if ($req->rowCount() > 0) {
				$data = new Account($req->fetch());
				return $data;
			} else {
				return "error";
			}
		}
	}