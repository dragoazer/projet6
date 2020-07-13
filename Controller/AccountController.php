<?php
	namespace Projet6\Controller;

	use Projet6\Entity\Account;
	use Projet6\Model\AccountModel;

	/**
	 * 
	 */
	class AccountController 
	{
		private $twig;
		private $accountModel;

		public function __construct ()
		{
			$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
			$this->twig = new \Twig\Environment($loader);
			$this->accountModel = new AccountModel();
		}

		public function displayRegistration () 
		{
			$template = $this->twig->load('registration.html');
			echo $template->render([
				'title' => 'Inscription.'
			]);
		}

		public function displayLogin ()
		{
			$template = $this->twig->load('connexion.html');
			echo $template->render([
				'title' => 'Connexion.'
			]);
		}

		public function setRegistration ()
		{
			$data = [
				"first_name" => $_POST['first_name'],
				"last_name" => $_POST['last_name'],
				"email" => $_POST['email'],
				"pwd" => $_POST['pwd']
			];
			$account = new Account($data);
			$connected = $this->accountModel->setRegistration($account);
		}

		public function setLogin ()
		{
			$data = [
				"email" => $_POST['email'],
				"pwd" => $_POST['pwd']
			];
			$account = new Account($data);
			$connected = $this->accountModel->setLogin($account);
			if ($connected != "error") {
				$_SESSION["connected"] = $connected->email();
				$_SESSION["last_name"] = $connected->last_name();
				$_SESSION["first_name"] = $connected->first_name();
				$_SESSION["user_type"] = $connected->user_type();
			} else {
				echo "error";
			}
		}
	}