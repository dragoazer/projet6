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
			if ($_SESSION['connected']["user_type"] == "admin") {
				$data = [
					"topic_id" => $_POST["topic_id"],
					"topic_type" => "game",
					"report_type" => $_POST["report_type"]
				];
				$report = new ReportGesture($data);
				$reportTopic = $this->reportModel->reportGameTopic($report);
			}
		}

		public function reportGameComment ()
		{
			if ($_SESSION['connected']["user_type"] == "admin") {
				$data = [
					"topic_id" => $_POST["topic_id"],
					"topic_type" => "game",
					"comment_id" => $_POST["comment_id"],
					"report_type" => $_POST["report_type"],
				];
				$report = new ReportGesture($data);
				$reportTopic = $this->reportModel->reportGameComment($report);
			}
		}

		public function displayForumGesture ()
		{
			if (isset($_SESSION['connected']) AND $_SESSION['connected']["user_type"] == "admin") {
				$datas =  $this->reportModel->maxPageReport(
					"none",
					"none",
					"creation_date",
					0,
					10
				);
				if ($datas != "error") {
					$nmbData = $this->reportModel->nmbPagePrecision(
						"none",
						"none",
						"creation_date",
						0,
						10
					);
					////////////
					$template = $this->twig->load('forumGesture.html');
					echo $template->render([
						'title' => 'Gestion de forum.',
						'css' => '/projet6/public/css/displayReport.css?'.time(),
						'datas' => $datas,
						'nmbData' => $nmbData
					]);
				} else {
					$template = $this->twig->load('forumGesture.html');
					echo $template->render([
						'title' => 'Gestion de forum.',
						'css' => '/projet6/public/css/displayReport.css?'.time(),
						'data' => 'error'
					]);
				}
			}
		}

		public function maxPageReport ()
		{
			if (isset($_SESSION['connected']) AND $_SESSION['connected']["user_type"] == "admin") {
				$topicDetails = $this->reportModel->maxPageReport(
					$_POST["typeTopic"],
					$_POST["topicCom"],
					$_POST["orderBy"], 
					(int) $_POST["min"],
					(int) $_POST["max"]
				);
				if ($topicDetails != 'error') {
					$nmbData = $this->reportModel->nmbPagePrecision(
						$_POST["typeTopic"],
						$_POST["topicCom"],
						$_POST["orderBy"], 
						(int) $_POST["min"],
						(int) $_POST["max"]
					);
					$datas = array(
						"topicDetails" => $topicDetails,
						"nmbData" => $nmbData
					);
					echo json_encode($datas);
				} else {
					echo 'error';
				}
			}
		}

		public function displayReportDetails ()
		{
			if (isset($_SESSION['connected']) AND $_SESSION['connected']["user_type"] == "admin") {
				$data = json_decode($_POST["press"], true);
				$details = $this->reportModel->displayReportDetails($data["type"], $data["id"]);
				// Si on envoi le POST foreign la fonction considère alors que l'on demande un commentaire et son topic associé.
				// On appelle donc en premier la base de donnée pour le commentaire et ensuite pour le topic.
				if (isset($data["foreign"]) AND $data["foreign"] != "" AND $details != "error") {
					$topicDetails = $this->reportModel->displayReportDetails($data["foreign"], $details["tableData"]["forumId"]);
					$total = array(
						'comment' => $details["tableData"],
						'topic' => $topicDetails["tableData"],
						'tableCom' => $details["table"],
						'tableTopic' => $topicDetails["table"]
					);
					echo json_encode($total);
					// Sinon on récupère juste la valeur de details et on envoi le topic.
				} else {
					$detailsData = array(
						'topic' => $details["tableData"],
						 'table' => $details["table"]
						);
					echo json_encode($detailsData);
				}
			}
		}

		public function deleteItem ()
		{
			if ($_SESSION['connected']["user_type"] == "admin") {
				if (isset($_POST["table"])) {
					switch ($_POST["table"]) {
						case "game_comment":
							$action = "supprGameComment";
							break;

						case "game_forum":
							$action = "supprGameTopic";
							break;
					}
				
					$GLOBALS["access"] =  password_hash("hereThePassWord", PASSWORD_DEFAULT);
					$ch = curl_init();
					$params = array (
						"id" => $_POST["id"],
						"access" => $GLOBALS["access"]
					);
					$defaults = array (
						CURLOPT_URL => 'http://localhost/projet6/public/index.php?action='.$action,
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => $params,
						CURLOPT_RETURNTRANSFER => true,
						CURLINFO_HEADER_OUT => true
					);
					curl_setopt_array($ch, $defaults);
					$result = curl_exec($ch);
					curl_close($ch);
				}
			}
		}

		public function modifyItem ()
		{
			if ($_SESSION['connected']["user_type"] == "admin") {
				var_dump($_POST["table"]);
				if (isset($_POST["table"])) {
					switch ($_POST["table"]) {
						case "game_comment":
							$action = "modifyGameComment";
							$postName = "comment";
							break;
							
						case "game_forum":
							$action = "modifyTopicGame";
							$postName = "content";
							break;
						}

						$GLOBALS["access"] =  password_hash("hereThePassWord", PASSWORD_DEFAULT);
						$ch = curl_init();
						$params = array (
							"id" => $_POST["id"],
							$postName =>$_POST["content"],
							"access" => $GLOBALS["access"]
						);
						$defaults = array (
							CURLOPT_URL => 'http://localhost/projet6/public/index.php?action='.$action,
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => $params,
							CURLOPT_RETURNTRANSFER => true,
							CURLINFO_HEADER_OUT => true
						);
						curl_setopt_array($ch, $defaults);
						$result = curl_exec($ch);
						curl_close($ch);
						$this->archiveReport($_POST["id"], $_POST["comOrTopic"]);
					}	
				}
			}

		public function archiveReport ($id = NULL, $comOrTopic = NULL)
		{
			if ($id === NULL OR $comOrTopic == NULL) {
				$id = $_POST["id"];
				$comOrTopic =  $_POST["comOrTopic"];
			}

			if (isset($_SESSION['connected']) AND $_SESSION['connected']["user_type"] == "admin") {
				$reportTopic = $this->reportModel->archiveReport($id,$comOrTopic);
			}
		}
	}