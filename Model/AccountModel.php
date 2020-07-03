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
				return "error";
			} else {
				$exec = $this->req->prepare("INSERT INTO account(first_name, last_name, user_type, email, pwd) VALUES (:first_name, :last_name, :user_type, :email, :pwd)");
				$exec->execute([
		        	"first_name"=> $account->first_name(),
		        	"last_name"=> $account->last_name(),
		        	"user_type"=>"member",
		        	"email"=> $account->email(),
		        	"pwd"=> password_hash($account->pwd(), PASSWORD_DEFAULT),
		    	]);
			}
		}
	}