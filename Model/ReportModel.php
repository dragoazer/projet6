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

		public function ShowReportData (int $begin , int $end)
		{
			$exec = $this->req->prepare("SELECT * FROM report_gesture ORDER BY creation_date DESC LIMIT :begining, :finish ");
			$exec->bindValue(':finish', $end, \PDO::PARAM_INT);
			$exec->bindValue(':begining', $begin, \PDO::PARAM_INT);
			$exec->execute();
			if ($exec->rowCount() > 0) {
				while ($data = $exec->fetch(\PDO::FETCH_ASSOC)) {
	      			$datas[] = new ReportGesture($data);
	      		}
				return $datas ?? "error";
			} else {
				return 'error';
			}
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
			$exec = $this->req->prepare("SELECT * FROM $table WHERE :id");
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

		public function archiveReport (ReportGesture $reportGesture)
		{
			$exec = $this->req->prepare("DELETE FROM report_gesture WHERE id = :id");
			$exec->execute(array(
				'id' =>$reportGesture->id()
			));
		}

		public function maxPageReport ($typeTopic, $topicCom, $orderBy, $min, $max)
		{
			//$max = $max-1;
			if ($topicCom == "com") {
				$comOrTopic = "comment_id IS NOT NULL";
			} elseif ($topicCom == "topic") {
				$comOrTopic = "comment_id IS NULL";
			} else {
				$comOrTopic = "";
			}
			///////////////////////////////////////////////////////////////////////////////
			if ($typeTopic != 'none' AND $typeTopic === "game" OR $typeTopic === "music" OR $typeTopic === "manga") {
				$condition = $comOrTopic != "" ? " AND ".$comOrTopic : '';
				if ($orderBy === "nmbReport") {
					$exec = $this->req->prepare(
						"SELECT * FROM report_gesture
						 WHERE topic_type = '$typeTopic' $condition
						 ORDER BY count(topic_id)
						 DESC LIMIT :min, :max" 
					);
				} else {
					$exec = $this->req->prepare(
						"SELECT * FROM report_gesture
						 WHERE topic_type = '$typeTopic' $condition
						 ORDER BY creation_date
						 DESC LIMIT :min, :max"	
					);
				}
				$noError = true;
			/////////////////////////////////////////////////////////////////////////////////////
			} else if ($typeTopic === 'none') { 
				if ($comOrTopic != "" AND $topicCom == "com") {
					/////////
					$condition = 
					"SELECT x.* FROM report_gesture x
				    JOIN (SELECT comment_id, COUNT(*) total FROM report_gesture  WHERE $comOrTopic GROUP BY comment_id) y 
					ON y.comment_id = x.comment_id 
					ORDER BY total DESC ,id LIMIT :min, :max"; 
					;
					/////////	
				} else if ($comOrTopic != "" AND $topicCom == "topic") {
					///////
					$condition = 
					"SELECT x.* FROM report_gesture x 
				    JOIN (SELECT topic_id, COUNT(*) total FROM report_gesture WHERE $comOrTopic GROUP BY topic_id) y 
					ON y.topic_id = x.topic_id 
					ORDER BY total DESC ,id LIMIT :min, :max";
					///////
				} else {
					///////
					$condition = 
					"SELECT x.* FROM report_gesture x 
				    JOIN (SELECT topic_id, COUNT(*) total FROM report_gesture GROUP BY topic_id) y 
					ON y.topic_id = x.topic_id 
					ORDER BY total DESC ,id LIMIT :min, :max";
					///////
				}
				////////////////////////////////////////
				$whereCondition = $comOrTopic != "" ? " WHERE ".$comOrTopic : '';
				if ($orderBy === "nmbReport") {
					$exec = $this->req->prepare(
						"$condition"
					);
				} else {
					$exec = $this->req->prepare(
						"SELECT * FROM report_gesture
						 $whereCondition
						 ORDER BY creation_date 
						 DESC LIMIT :min, :max"
					);
				}
				$noError = TRUE;
			}
			////////////////////////////////////////////////////////////////////////////////////
			if (isset($noError)) {
				$exec->bindValue(':max', $max, \PDO::PARAM_INT);
				$exec->bindValue(':min', $min, \PDO::PARAM_INT);
				$exec->execute();

				if ($exec->rowCount() > 0) {
					while ($data = $exec->fetch(\PDO::FETCH_ASSOC)) {
		      			$datas[] = new ReportGesture($data);
		      		}
					return $datas ?? 'error';
				} else {
					return 'error';
				}
			} else {
				return 'error';
			}	
		}

		public function nmbPage ()
		{
			$exec = $this->req->prepare("SELECT COUNT(*) FROM report_gesture");
			$exec->execute();
			if ($exec->rowCount() > 0) {
				$data = $exec->fetch(\PDO::FETCH_ASSOC);	
				return $data;
			} else {
				return 'error';
			}
		}
	}