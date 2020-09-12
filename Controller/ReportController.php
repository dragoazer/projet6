<?php
	namespace Projet6\Controller;

	use Projet6\Entity\ReportGesture;
	use Projet6\Model\ReportModel;

	class ReportController 
	{
		private $twig;

		public function __construct ()
		{
			$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
			$this->twig = new \Twig\Environment($loader, ['debug' => true,]);
			$this->twig->addExtension(new \Twig\Extension\DebugExtension());
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
			$reportTopic = $this->reportModel->reportGameTopic($report);
		}

		public function reportGameComment ()
		{
			$data = [
				"topic_id" => $_POST["topic_id"],
				"topic_type" => "game",
				"comment_id" => $_POST["comment_id"],
				"report_type" => $_POST["report_type"],
			];
			$report = new ReportGesture($data);
			$reportTopic = $this->reportModel->reportGameComment($report);
		}

		public function displayForumGesture ()
		{
			$datas =  $this->reportModel->ShowReportData(0,intval(8446744073709551615));
			
			//////// count number of occurence
			$array = (array) $datas;
			foreach ($array as $key => $value) {
				if ($value->comment_id() == "") {
					$arr[] = $value->topic_id();
				}
			}
			foreach ($array as $key => $value) {
				if ($value->comment_id() != "") {
					$arrCom[] = $value->comment_id();
				}
			}

			$nmbOccTopic = array_count_values($arr);
			$nmbOccComment = array_count_values($arrCom);
			//////////////////

			$template = $this->twig->load('forumGesture.html');
			echo $template->render([
				'title' => 'Gestion de forum.',
				'datas' => $datas,
				'nmbOccTopic' => $nmbOccTopic,
				"nmbOccComment" => $nmbOccComment
			]);
		}

		public function maxPage ()
		{

		}

		public function displayReportDetails ()
		{
			$data = json_decode($_POST["press"], true);
			$details = $this->reportModel->displayReportDetails($data["type"], $data["id"]);
			var_dump($details);
			/*if ($data["foreign"] != "") {
				$topicDetails = $this->reportModel->displayReportDetails($data["foreign"], $details->forumId());
			}*/
		}
	}