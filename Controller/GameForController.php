<?php
	namespace Projet6\Controller;

	use Projet6\Entity\GameForum;
	use Projet6\Entity\GameComment;
	use Projet6\Model\GameForModel;
	use Projet6\Model\GameCommentModel;
	/**
	 * 
	 */
	class GameForController 
	{
		private $twig;

		public function __construct ()
		{
			$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
			$this->twig = new \Twig\Environment($loader, [
    			'debug' => true,
			]);
			$this->twig->addExtension(new \Twig\Extension\DebugExtension());
			$this->gameForModel = new GameForModel();
			$this->gameCommentModel = new GameCommentModel();
		}


		public function displayGameForum ()
		{
			$template = $this->twig->load('game.html');
			echo $template->render([
				'title' => 'Forum jeux vidéo.',
				'session' => $_SESSION["connected"] ?? ""
			]);
		}

		public function searchGameForum ()
		{
			$displayAllTopic = $this->gameForModel->displayAllTopic($_POST["min"],$_POST["max"]);
			$datas = json_encode($displayAllTopic);
			echo $datas;
		}

		public function newTopic ()
		{
			$data = [
				"dev" => $_POST['creator'],
				"name" => $_POST['name'],
				"content" => $_POST['content'],
				"title" =>  $_POST['title'],
				"editor" => $_SESSION['connected']["pseudo"]
			];
			$newTopic = new GameForum($data);
			$newTopicCreated = $this->gameForModel->newTopic($newTopic);
		}

		public function displayNewTopic ()
		{
			$template = $this->twig->load('newGame.html');
				echo $template->render([
				'title' => `Création d'un nouveau topic.`,
			]);
		}

		public function displayTopic ()
		{
			$data = [
				"id" => $_GET['id']
			];
			$topic = new GameForum($data);
			$modelTopic = $this->gameForModel->displayTopic($topic);

			$template = $this->twig->load('gameTopic.html');
				echo $template->render([
				'data' => $modelTopic,
				'css' => '/projet6/public/css/displayTopic.css?'.time(),
				'title' => `Sujet: `.$modelTopic->title().`.`,
				'session' => $_SESSION["connected"] ?? "",
			]);
		}

		public function modifyTopic ()
		{
			$data = [
				"id" => $_POST['id'],
				"content" => $_POST['content'],
			];
			$topic = new GameForum($data);
			$modelTopic = $this->gameForModel->newTopic($topic);
		}

		public function  maxPageGame ()
		{
			$modelTopic = $this->gameForModel->maxPageGame();
			echo $modelTopic;
		}

		public function addGameComment ()
		{

		}
	}