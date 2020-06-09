<?php
	namespace Projet6\Model;

	use Projet6\Model\Manager;
	use Projet6\Entity\Account;

	/**
	 * 
	 */
	class AccountModel extends Manager
	{
		public function setRegistration (Account $account)
		{
			$req = $this->dbConnect()->prepare("SELECT first_name, last_name, email FROM account WHERE email=?");
			$req->execute(array(
				$account->email(),
			));
			if ($req->fetch()) {
				return "error";
			} else {
				$req = $this->dbConnect()->prepare("INSERT INTO account(first_name, last_name, user_type, profile_picture, email, pwd) VALUES (:first_name, :last_name, :user_type, :profile_picture, :email, :pwd)");
				$req->execute([
		        	"first_name"=> $account->first_name(),
		        	"last_name"=> $account->last_name(),
		        	"user_type"=>"member",
		        	"profile_picture"=>"public/image/basicProfile.png",
		        	"email"=> $account->email(),
		        	"pwd"=> $account->pwd(),
		    	]);
			}
		}
	}