<?php
	namespace Projet6\Model;

	use Projet6\Model\Manager;
	use Projet6\Entity\Chatting;

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

		public function sendChatMessage (Chatting $chat)
		{
			$exec = $this->req->prepare("INSERT INTO chatting(pseudo, message, chat_date) VALUES (:pseudo, :message, :chat_date)");
			$exec->execute(array(
				"pseudo" => $chat->pseudo(),
				"message" => $chat->message(),
				"chat_date" => date("Y-m-d")
			));
		}

		public function showChat ()
		{
			$exec = $this->req->prepare("SELECT * FROM chatting");
		 	$exec->execute();
			if ($exec->rowCount() > 0) {
				while ($data = $exec->fetch(\PDO::FETCH_ASSOC))
	    		{
	      			$datas[] = new Chatting($data);
	      		}
				echo json_encode($datas) ?? "error";
			} else {
				echo 'errorNoCount';
			}
		}

	}