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
			if ($_SESSION['connected']["user_type"] == "admin") {
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
					'css' => '/projet6/public/css/displayReport.css?'.time(),
					'datas' => $datas,
					'nmbOccTopic' => $nmbOccTopic,
					"nmbOccComment" => $nmbOccComment
				]);
			}
		}

		public function maxPage ()
		{

		}

		public function displayReportDetails ()
		{
			if ($_SESSION['connected']["user_type"] == "admin") {
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
					print_r($result);	
					curl_close($ch);
				}
			}
		}

		public function modifyItem ()
		{
			if ($_SESSION['connected']["user_type"] == "admin") {
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
						print_r($result);
						curl_close($ch);
					}	
				}
			}

		public function archiveReport ()
		{
			if ($_SESSION['connected']["user_type"] == "admin") {
				$data = [
					"id" => $_POST["id"]
				];
				$report = new ReportGesture($data);
				$reportTopic = $this->reportModel->archiveReport($report);
			}
		}
	}