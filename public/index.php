<?php
	session_start();
	
	require_once "../vendor/autoload.php";

	use Projet6\Controller\GeneralController;
	use Projet6\Controller\AccountController;
	use Projet6\Controller\gameForController;

	$generalController = new GeneralController();
	$accountController = new AccountController();
	$gameForController = new gameForController();

	if (isset($_GET["action"])) {
	 	switch ($_GET["action"]) {
	 		case 'home':
        		$generalController->displayHome();
        		break;
////////////// FORUM
////////////// GAME
        	case 'displayGameForum':
        		$gameForController->displayGameForum();
        		break;

            case 'newTopicGame':
                $gameForController->newTopic();
                break;

            case 'displayNewTopicGame':
                $gameForController->displayNewTopic();
                break;

        	case 'ShowTopicGame':
        		$gameForController->displayTopic();
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

            case 'addGameComment':
                $gameForController->addGameComment();
                break;

/////////// ACCOUNT GESTURE
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

