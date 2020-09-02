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
			$exec = $this->req->prepare("INSERT INTO report_gesture(topic_id, topic_type, report_type) VALUES (:topic_id, :topic_type, :report_type)");
			$exec->execute(array(
				"topic_id" => $reportGesture->topic_id(),
				"topic_type" => $reportGesture->topic_type(),
				"report_type" => $reportGesture->report_type()
			));
		}

		public function reportGameComment (ReportGesture $reportGesture)
		{
			$exec = $this->req->prepare("INSERT INTO report_gesture(topic_id, comment_id, topic_type, report_type) VALUES (:topic_id, :comment_id, :topic_type, :report_type)");
			$exec->execute(array(
				"topic_id" => $reportGesture->topic_id(),
				"comment_id" => $reportGesture->comment_id(),
				"topic_type" => $reportGesture->topic_type(),
				"report_type" => $reportGesture->report_type()
			));
		}
	}