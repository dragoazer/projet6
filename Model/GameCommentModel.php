<?php
	namespace Projet6\Model;

	use Projet6\Model\Manager;
	use Projet6\Entity\GameComment;

	/**
	 * 
	 */
	class GameCommentModel extends Manager
	{
		private $req;

		public function __construct()
		{
			$this->req = $this->dbConnect();
		}

		public function displayGameComment (GameComment $gameComment, $min, $max)
		{
			$exec = $this->req->prepare("SELECT * FROM game_comment WHERE forumId = :forumId ORDER BY post_date DESC, id DESC LIMIT :begining, :finish");
			$exec->bindValue(':finish', $max, \PDO::PARAM_INT);
			$exec->bindValue(':begining', $min, \PDO::PARAM_INT);
			$exec->bindValue(':forumId', $gameComment->forumId(), \PDO::PARAM_INT);
			$exec->execute();
			if ($exec->rowCount() > 0) {
				while ($data = $exec->fetch(\PDO::FETCH_ASSOC))
	    		{
	      			$datas[] = new GameComment($data);
	      		}
				echo json_encode($datas) ?? "error";
			} else {
				echo 'errorNoCount';
			}
		}

		public function addGameComment (GameComment $gameComment)
		{
			$exec = $this->req->prepare("INSERT INTO game_comment(pseudo, comment, post_date, forumId) VALUES (:pseudo, :comment, :post_date, :forumId)");
			$exec->execute(array(
				"pseudo" => $gameComment->pseudo(),
				"comment" => $gameComment->comment(),
				"post_date" => date("Y-m-d"),
				"forumId" => $gameComment->forumId()
			));
		}

		public function maxPageComment (GameComment $gameComment)
		{
			$exec = $this->req->prepare("SELECT COUNT(*) FROM game_comment WHERE :id");
			$exec->bindValue(':id', $gameComment->forumId(), \PDO::PARAM_INT);
			$exec->execute();
			$count = $exec->fetch();
			return $count[0];
		}

		public function supprGameCom (GameComment $gameComment)
		{
			$exec = $this->req->prepare("DELETE FROM game_comment WHERE forumId=?");
			$exec->execute(array(
				"forumId" => $gameForum->forumId()
			));
		}
	}