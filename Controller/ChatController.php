<?php
	namespace Projet6\Controller;

	use Projet6\Entity\Chat;
	use Projet6\Model\ChatModel;

	/**
	 * 
	 */

	class ChatController {

		private $chatModel;

		public function __construct ()
		{
			$this->chatModel = new ChatModel();
		}

		public function sendChatMessage () 
		{
			if (isset($_SESSION["connected"]) AND isset($_POST["inputMessage"])) {
				$data = [
					"pseudo" => $_SESSION["connected"]["pseudo"],
					"message" => $_POST["inputMessage"],
					"time" => date('H:i'),
					"date" => date('Y-m-d')

				];
				$chat = new Chat($data);
				$chatModel = $this->chatModel->sendChatMessage($account);
			}
		}

		public function showChat ()
		{
			$data = [
			];
			$chat = new Chat($data);
			$chatModel = $this->chatModel->showChat($account);	
		}
	}