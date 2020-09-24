<?php
	namespace Projet6\Controller;

	use Projet6\Entity\GameComment;
	use Projet6\Model\GameComModel;

	use Projet6\Model\GameCommentModel;
	/**
	 * 
	 */
	class GameComController 
	{
		private $twig;

		public function __construct ()
		{
			$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
			$this->twig = new \Twig\Environment($loader, [
    			'debug' => true,
			]);
			$this->twig->addExtension(new \Twig\Extension\DebugExtension());
			$this->gameCommentModel = new GameCommentModel();
		}

		public function addGameComment ()
		{
			if ($_SESSION['connected']) {
				$data = [
					"forumId" => $_POST["id"],
					"comment" => $_POST["comment"],
					"pseudo" => $_SESSION["connected"]["pseudo"]
				];
				$comment = new GameComment($data);
				$modelComment = $this->gameCommentModel->addGameComment($comment);
			}
		}

		public function displayGameComment ()
		{
			$data = [
				"forumId" => $_POST["forumId"],
			];
			$comment = new GameComment($data);
			if (isset($_POST["min"]) AND isset($_POST["max"]) AND $_POST["min"] >= 0 AND $_POST["max"] > 0) {
				$comments = $this->gameCommentModel->displayGameComment($comment, $_POST["min"], $_POST["max"]);
			}
		}

		public function supprGameComment ()
		{
			if (isset($_SESSION['connected']["user_type"]) AND $_SESSION['connected']["user_type"] == "admin" OR $_POST['access'] === $_REQUEST["access"]) {
				$data = [
					"id" => $_POST["id"]
				];
				$comId = new GameComment($data);
				$supprCom = $this->gameCommentModel->supprGameCom($comId);
			}
		}

		public function modifyGameComment ()
		{
			if (isset($_SESSION['connected']["user_type"]) AND $_SESSION['connected']["user_type"] == "admin" OR $_POST['access'] === $_REQUEST["access"]) {
				$data = [
					"id" => $_POST["id"],
					"comment" => $_POST["comment"]
				];
				$modCom = new GameComment($data);
				$supprCom = $this->gameCommentModel->modGameCom($modCom);
			}
		}

		public function maxPageComment ()
		{
			$data = [
				"forumId" => $_POST["id"],
			];
			$comment = new GameComment($data);
			$modelComment = $this->gameCommentModel->maxPageComment($comment);
			echo $modelComment;
		}
	}