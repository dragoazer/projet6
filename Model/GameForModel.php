<?php
	namespace Projet6\Model;

	use Projet6\Model\Manager;
	use Projet6\Entity\GameForum;

	/**
	 * 
	 */
	class GameForModel extends Manager
	{
		private $req;

		public function __construct()
		{
			$this->req = $this->dbConnect();
		}

		public function newTopic (GameForum $GameForum)
		{
			
		}
	}