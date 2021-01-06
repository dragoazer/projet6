<?php
	namespace Projet6\Controller;

	use Projet6\Entity\Chatting;
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
			if (isset($_SESSION["connected"]) AND isset($_POST["inputMessage"]) AND strlen($_POST["inputMessage"]) < 50 AND strlen($_POST["inputMessage"]) > 1 ) {
				$data = [
					"pseudo" => $_SESSION["connected"]["pseudo"],
					"message" => $_POST["inputMessage"],
				];
				$chat = new Chatting($data);
				$chatModel = $this->chatModel->sendChatMessage($chat);
			}
		}

		public function showChat ()
		{
			$chatModel = $this->chatModel->showChat();	
		}
	}