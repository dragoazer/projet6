<?php
	session_start();
	
	require_once "../vendor/autoload.php";

	use Projet6\Controller\GeneralController;
	use Projet6\Controller\AccountController;
	use Projet6\Controller\GameForController;
    use Projet6\Controller\GameComController;
    use Projet6\Controller\ReportController;

	$generalController = new GeneralController();
	$accountController = new AccountController();
	$gameForController = new GameForController();
    $gameComController = new GameComController();
    $reportController  = new  ReportController();

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
	 	}
	} else {
    	$generalController->displayHome();
    }

