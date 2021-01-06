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
				"pseudo" => $_POST['pseudo'],
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
			$pwdVerify =  $this->accountModel->verifyPwd($account);
			if (password_verify($_POST['pwd'], $pwdVerify[0])) {
				$connected = $this->accountModel->setLogin($account);
				if ($connected != "error") {
					$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
					$twig = new \Twig\Environment($loader);
					$_SESSION['connected'] = array(
	    				'email' => $connected->email(),
						'pseudo' => $connected->pseudo(),
						'user_type' => $connected->user_type(),
						'profile_picture' => $connected->profile_picture()
					);
					///////////// doesn't work
					$twig->addGlobal('connected', $_SESSION['connected']);
				} else {
					echo "error";
				}
			} else {
				echo "error";
			}
		}

		public function signOut ()
		{
			session_destroy();
			header('Location: index.php?action=home');
		}

		public function displayAccountGesture ()
		{
			if (isset($_SESSION["connected"])) {

				$template = $this->twig->load('accountGesture.html');
				echo $template->render([
					'title' => 'Gestion de compte',
					'css' => './css/accountGesture.css?'.time(),
					'session' => $_SESSION["connected"] ?? ""
				]);
			}
		}

		public function changeImageProfile ()
		{
			if (isset($_SESSION["connected"]) AND isset($_FILES['avatar'])) {
				if ($_FILES['avatar']["size"] < 1000000 AND in_array($_FILES['avatar']['type'], ['image/gif', 'image/jpeg', 'image/png'])) {
					$uploaddir = './img/profile/';
					$fileType = explode("/", $_FILES['avatar']['type']);
					$newName = $_SESSION["connected"]['pseudo']."ImgProfile.".$fileType[1];
					$uploadfile = $uploaddir.$newName;
					$_SESSION["connected"]["profile_picture"] = $uploadfile;
					if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) {
						$data = [
							"pseudo" => $_SESSION["connected"]['pseudo'],
							"profile_picture" => $uploadfile
						];
						$account = new Account($data);
						$connected = $this->accountModel->modifyImgProfile($account);
					} else {
						return 'error';
					}
				}
			}
		}

		public function changePwd ()
		{
			if (!empty($_POST["newPwd"]) AND !empty($_POST["oldPwd"]) AND isset($_SESSION["connected"])) {
				if (strlen($_POST["newPwd"]) >= 8 AND preg_match("/([a-zA-Z0-9._-]){8}/", $_POST["newPwd"]) AND $_POST["newPwd"] != $_POST["oldPwd"]) {
					$data = [
						"email" => $_SESSION["connected"]["email"],
					];
					$account = new Account($data);
					$pwdVerify =  $this->accountModel->verifyPwd($account);
					if (password_verify($_POST["oldPwd"], $pwdVerify[0])) {
						$this->accountModel->modifyPwd($_POST["newPwd"], $_SESSION["connected"]["email"]);
					} else {
						echo 'error';
					}
				} else {
					echo 'error';
				}
			}
		}
	}