<?php
	session_start();
	
	require_once "../vendor/autoload.php";

	use Projet6\Controller\GeneralController;
	use Projet6\Controller\AccountController;
	use Projet6\Controller\GameForController;
    use Projet6\Controller\GameComController;
    use Projet6\Controller\ReportController;
    use Projet6\Controller\ChatController;

	$generalController = new GeneralController();
	$accountController = new AccountController();
	$gameForController = new GameForController();
    $gameComController = new GameComController();
    $reportController  = new  ReportController();
    $chatController = new ChatController();

	if (isset($_GET["action"])) {
	 	switch ($_GET["action"]) {
	 		case 'home':
        		$generalController->displayHome();
        		break;
/////////////////// FORUM //////////////////
//////////////// GAME ///////////////////
///////////DISPLAY
        	case 'displayGameForum':
        		$gameForController->displayGameForum();
        		break;

            case 'displayNewTopicGame':
                $gameForController->displayNewTopic();
                break;

            case 'ShowTopicGame':
                $gameForController->displayTopic();
                break;

//////// UTILITY

            case 'newTopicGame':
                $gameForController->newTopic();
                break;

            case 'supprGameTopic':
                $gameForController->supprGameTopic();
                break;

            case 'modifyTopicGame':
                $gameForController->modifyTopic();
                break;

            case 'searchGameForum':
                $gameForController->searchGameForum();
                break;

            case 'maxPageGame':
                $gameForController->maxPageGame();
                break;

            case 'searchForGame':
                $gameForController->searchForGame();
                break;

///////// COMMENT GAME
            case 'addGameComment':
                $gameComController->addGameComment();
                break;

            case 'supprGameComment':
                $gameComController->supprGameComment();
                break;

            case 'displayGameComment':
                $gameComController->displayGameComment();
                break;

            case 'maxPageComment':
                $gameComController->maxPageComment();
                break;

            case 'modifyGameComment':
                $gameComController->modifyGameComment();
                break;

////////////// REPORT ///////////////
            case 'reportGameTopic':
                $reportController->reportGameTopic();
                break;

            case 'reportGammeComment':
                $reportController->reportGameComment();
                break;
                
            case 'displayForumGesture':
                $reportController->displayForumGesture();
                break;

            case 'displayReportDetails':
                $reportController->displayReportDetails();
                break;

            case "deleteItem":
                $reportController->deleteItem();
                break;

            case 'modifyItem':
                $reportController->modifyItem();
                break;

            case 'archiveReport':
                $reportController->archiveReport();
                break;

            case 'maxPageReport':
                $reportController->maxPageReport();
                break;
///////////////// MUSIC ///////////////////
/////////// ACCOUNT GESTURE ////////////////
        	case 'registration':
        		$accountController->displayRegistration();
        		break;

        	case 'setRegistration':
        		$accountController->setRegistration();
        		break;

            case 'displayLogin':
                $accountController->displayLogin();
                break;

            case 'setLogin':
                $accountController->setLogin();
                break;
                
            case 'signOut':
                $accountController->signOut();
                break;

            case 'displayAccountGesture':
                $accountController->displayAccountGesture();
                break;

            case 'changeImageProfile':
                $accountController->changeImageProfile();
                break;

            case 'changePwd':
                $accountController->changePwd();
                break;

///////////////// CHAT GESTURE /////////////
            case 'sendChatMessage':
                $chatController->sendChatMessage();
                break;

            case 'showChat':
             $chatController->showChat();
             break;
//////////////// MUSIC GESTURE //////////////
             /*case 'actualRadioMusic':
             
             break;*/
	 	}
	} else {
    	$generalController->displayHome();
    }

