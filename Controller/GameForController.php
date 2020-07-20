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
			$template = $this->twig->load('game.html');
				echo $template->render([
				'title' => 'Forum jeux vidéo.',
			]);
		}

		public function newTopic ()
		{
			$data = [
				"dev" => $_POST['creator'],
				"date" => $_POST['date'],
				"name" => $_POST['name'],
				"content" => $_POST['content'],
				"title" =>  $_POST['title']
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
	}