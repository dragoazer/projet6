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
			        "creation_date"=>date("Y-m-d"),
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
			$exec = $this->req->prepare("SELECT * FROM game_forum ORDER BY creation_date DESC LIMIT :begining, :finish ");
			$exec->bindValue(':finish', $end, \PDO::PARAM_INT);
			$exec->bindValue(':begining', $begin, \PDO::PARAM_INT);
			$exec->execute();
			if ($exec->rowCount() > 0) {
				while ($data = $exec->fetch(\PDO::FETCH_ASSOC))
	    		{
	      			$datas[] = new GameForum($data);
	      		}
				return $datas ?? "error";
			} else {
				return 'error';
			}
		}

		public function displayTopic (GameForum $gameForum)
		{
			$exec = $this->req->prepare("SELECT * FROM game_forum WHERE :id");
			$exec->execute(array(
				"id" => $gameForum->id(),
			));
			$datas = new GameForum($exec->fetch());
			return $datas;
		}

		public function maxPageGame ()
		{
			$exec = $this->req->prepare("SELECT COUNT(*) FROM game_forum");
			$exec->execute();
			$maxTopic = $exec->fetch();
			return $maxTopic[0];
		}

		public function supprGameTopic (GameForum $gameForum)
		{
			$exec = $this->req->prepare("DELETE FROM game_forum WHERE id = :id");
			$exec->execute(array(
				"id" => $gameForum->id()
			));
		}

		public function modifyTopic (GameForum $gameForum)
		{
			$exec = $this->req->prepare("UPDATE game_forum SET content = :content, modified = :modified  WHERE id = :id");
			$exec->execute(array(
				"content" => $gameForum->content(),
				"id" => $gameForum->id(),
				"modified" => $gameForum->modified()
			));
		}

	}