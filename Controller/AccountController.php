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

		public function setRegistration ()
		{
			$data = [
				"first_name" => $_POST['first_name'],
				"last_name" => $_POST['last_name'],
				"email" => $_POST['email'],
				"pwd" => password_hash($_POST['password'], PASSWORD_DEFAULT),
			];
			$account = new Account($data);
			$connected = $this->accountModel->setRegistration($account);
		}
	}