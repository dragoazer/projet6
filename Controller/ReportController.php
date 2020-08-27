<?php
	namespace Projet6\Controller;

	use Projet6\Entity\ReportGesture;
	use Projet6\Model\ReportModel;

	class ReportController 
	{
		public function __construct ()
		{
			$this->reportModel = new ReportModel();
		}

		public function reportGameTopic ()
		{
			$data = [
				"topic_id" => $_POST["topic_id"],
				"topic_type" => "game",
				"report_type" => $_POST["report_type"]
			];
			$report = new ReportGesture($data);
			var_dump($report);
			$reportTopic = $this->reportModel->reportGameTopic($report);
		}
	}