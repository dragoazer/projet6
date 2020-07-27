<?php
	namespace Projet6\Controller;

	use Projet6\Entity\GameForum;
	use Projet6\Model\GameForModel;
	/**
	 * 
	 */
	class GameForController 
	{
		private $twig;

		public function __construct ()
		{
			$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
			$this->twig = new \Twig\Environment($loader);
			$this->gameForModel = new GameForModel();

		}


		public function displayGameForum ()
		{
			$displayAllTopic = $this->gameForModel->displayAllTopic(1,5);
			$template = $this->twig->load('game.html');
				echo $template->render([
				'title' => 'Forum jeux vidéo.',
				'listTopic' => $displayAllTopic,
				'session' => $_SESSION["connected"] ?? ""
			]);
		}

		public function newTopic ()
		{
			$data = [
				"dev" => $_POST['creator'],
				"creation_date" => $_POST['creation_date'],
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
			$modelTopic = $this->gameForModel->displayTopic($newTopic);
			$template = $this->twig->load('gameTopic.html');
				echo $template->render([
				'title' => `Sujet: `.$modelTopic->title().`.`,
			]);
		}

		public function modifyTopic ()
		{
			$data = [
				"id" => $_POST['id'],
				"content" => $_POST['content'],
			];
			$topic = new GameForum($data);
			$modelTopic = $this->gameForModel->newTopic($newTopic);
		}
	}