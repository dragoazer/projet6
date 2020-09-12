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
				while ($data = $exec->fetch(\PDO::FETCH_ASSOC))
	    		{
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
				return $data ?? "error";
			} else {
				return 'error';
			}
		}
	}