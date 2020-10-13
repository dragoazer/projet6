<?php
	namespace Projet6\Model;

	use Projet6\Model\Manager;
	use Projet6\Entity\ReportGesture;

	/**
	 * 
	 */
	class ReportModel extends Manager
	{

		private $req;

		public function __construct()
		{
			$this->req = $this->dbConnect();
		}

		public function reportGameTopic (ReportGesture $reportGesture)
		{
			$exec = $this->req->prepare("INSERT INTO report_gesture(topic_id, topic_type, report_type, creation_date) VALUES (:topic_id, :topic_type, :report_type, :creation_date)");
			$exec->execute(array(
				"topic_id" => $reportGesture->topic_id(),
				"topic_type" => $reportGesture->topic_type(),
				"report_type" => $reportGesture->report_type(),
				"creation_date"=>date("Y-m-d"),
			));
		}

		public function reportGameComment (ReportGesture $reportGesture)
		{
			$exec = $this->req->prepare("INSERT INTO report_gesture(topic_id, comment_id, topic_type, report_type ,creation_date) VALUES (:topic_id, :comment_id, :topic_type, :report_type, :creation_date)");
			$exec->execute(array(
				"topic_id" => $reportGesture->topic_id(),
				"comment_id" => $reportGesture->comment_id(),
				"topic_type" => $reportGesture->topic_type(),
				"report_type" => $reportGesture->report_type(),
				"creation_date"=>date("Y-m-d"),
			));
		}

		public function displayReportDetails (string $dataBase, int $id)
		{
			 switch($dataBase) {
        		case 'game_comment':
            		$table = 'game_comment';
            		break;

            	case 'game_forum':
            		$table = 'game_forum';
            		break;
    		}
			$exec = $this->req->prepare("SELECT * FROM $table WHERE id = :id");
			$exec->bindValue(':id', $id, \PDO::PARAM_INT);
			$exec->execute();
			if ($exec->rowCount() > 0) {
				$data = $exec->fetch(\PDO::FETCH_ASSOC);
				$datas = array (
					"tableData" => $data,
					"table" => $table
				);
				return $datas ?? "error";
			} else {
				return 'error';
			}
		}

		public function archiveReport ($id, $comOrTopic)
		{
			if ($comOrTopic == "com") {
				$request = "DELETE FROM report_gesture WHERE comment_id = :id";
			} else {
				$request = "DELETE FROM report_gesture WHERE topic_id = :id AND comment_id IS NULL";
			}
			var_dump($request,$id, $comOrTopic);
			$exec = $this->req->prepare("$request");
			$exec->execute(array(
				'id' => $id
			));
		}

		public function maxPageReport ($typeTopic, $topicCom, $orderBy, $min, $max)
		{
			$orderByVar = $orderBy == "nmbReport" ? "total" : "creation_date";
			$condition = $typeTopic == "none" ? "" : "AND topic_type = '$typeTopic'";
			if ($topicCom == "com") {
				$request = "SELECT * , COUNT(*) total
					FROM report_gesture
					WHERE comment_id IS NOT NULL $condition
					GROUP BY comment_id 
					ORDER BY total DESC
					LIMIT :min, :max";
			} else if ($topicCom == "topic") {
				$request = "SELECT * , COUNT(*) total
					FROM report_gesture
					WHERE comment_id IS NULL $condition
					GROUP BY topic_id 
					ORDER BY total DESC
					LIMIT :min, :max";
			} else {
				$request = "SELECT * , COUNT(*) total 
					FROM report_gesture 
					WHERE comment_id IS NOT NULL $condition
					GROUP BY comment_id 
					UNION 
					SELECT * , COUNT(*) total 
					FROM report_gesture 
					WHERE comment_id IS NULL $condition
					GROUP BY topic_id
					ORDER BY $orderByVar DESC 
					LIMIT :min, :max";
			}
			/////////////////////////////////////////////////////////////////////////////////////
			$exec = $this->req->prepare("$request");
			$exec->bindValue(':max', $max, \PDO::PARAM_INT);
			$exec->bindValue(':min', $min, \PDO::PARAM_INT);
			$exec->execute();

			if ($exec->rowCount() > 0) {
				while ($data = $exec->fetch(\PDO::FETCH_ASSOC)) {
		      		$datas[] = $data;
		      	}
				return $datas ?? 'error';
			} else {
				return 'error';
			}
		}

		public function nmbPagePrecision ($typeTopic, $topicCom, $orderBy,$min, $max)
		{
			$orderByVar = $orderBy == "nmbReport" ? "total" : "creation_date";
			$condition = $typeTopic == "none" ? "" : "AND topic_type = '$typeTopic'";
			if ($topicCom == "com") {
				$request = "SELECT * , COUNT(*) total
					FROM report_gesture
					WHERE comment_id IS NOT NULL $condition
					GROUP BY comment_id 
					ORDER BY total DESC";
			} else if ($topicCom == "topic") {
				$request = "SELECT * , COUNT(*) total
					FROM report_gesture
					WHERE comment_id IS NULL $condition
					GROUP BY topic_id 
					ORDER BY total DESC";
			} else {
				$request = "SELECT * , COUNT(*) total 
					FROM report_gesture 
					WHERE comment_id IS NOT NULL $condition
					GROUP BY comment_id 
					UNION 
					SELECT * , COUNT(*) total 
					FROM report_gesture 
					WHERE comment_id IS NULL $condition
					GROUP BY topic_id
					ORDER BY $orderByVar DESC";
			}
			/////////////////////////////////////////////////////////////////////////////////////
			$exec = $this->req->prepare("$request");
			$exec->bindValue(':max', $max, \PDO::PARAM_INT);
			$exec->bindValue(':min', $min, \PDO::PARAM_INT);
			$exec->execute();

			if ($exec->rowCount() > 0) {
				return ceil($exec->rowCount()/$max-$min) ?? 'error';
			} else {
				return 'error';
			}	
		}
	}