<?php
	namespace Projet6\Model;

	use Projet6\Model\Manager;
	use Projet6\Entity\Chat;

	/**
	 * 
	 */
	class ChatModel extends Manager
	{
		private $req;

		public function __construct()
		{
			$this->req = $this->dbConnect();
		}

		public function sendChatMessage (Chat $chat)
		{
			$exec = $this->req->prepare("INSERT INTO chat(pseudo, message, 'time', 'date') VALUES (:pseudo, :message, :'time', :'date')");
			$exec->execute(array(
				"pseudo" => $chat->pseudo(),
				"message" => $chat->comment(),
				"time" => $chat->time(),
				"date" => $chat->date()
			));
		}

		public function showChat ()
		{
			
		}
	}