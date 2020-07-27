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

		public function newTopic (GameForum $gameForum)
		{
			$exec = $this->req->prepare("SELECT title FROM game_forum WHERE title=?");
			$exec->execute(array(
				$gameForum->title()
			));
			if ($exec->fetch()) {
				echo "error";
			} else {
				$exec = $this->req->prepare("INSERT INTO game_forum(dev, creation_date, name, content, title, editor, modified) VALUES (:dev, :creation_date, :name, :content, :title, :editor, :modified)");
				$exec->execute([
			        "dev"=> $gameForum->dev(),
			        "creation_date"=>$gameForum->creation_date(),
			        "name" => $gameForum->name(),
			        "content"=> $gameForum->content(),
			        "title"=> $gameForum->title(),
			        "editor" => $gameForum->editor(),
			        "modified" => 0
			    ]);
			}
		}

		public function displayAllTopic (int $begin , int $end)
		{
			$exec = $this->req->prepare("SELECT * FROM game_forum WHERE id BETWEEN :begining AND :finish");
			$exec->execute(array(
				"begining" => $begin,
				"finish" => $end
			));
			$data = $exec->fetch(\PDO::FETCH_ASSOC);
			return $data;
		}

		public function displayTopic (GameForum $gameForum)
		{
			$exec = $this->req->prepare("SELECT * FROM game_forum WHERE :id");
			$exec->execute(array(
				"id" => $gameForum->id(),
			));
			$data = $exec->fetch();
			return $data;
		}
	}