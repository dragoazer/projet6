<?php
	session_start();
	
	require_once "../vendor/autoload.php";

	use Projet6\Controller\GeneralController;
	use Projet6\Controller\AccountController;
	//use Projet6\Controller\ForumController;

	$generalController = new GeneralController();
	$accountController = new AccountController();
	//$forumController = new ForumController();

	if (isset($_GET["action"])) {
	 	switch ($_GET["action"]) {
	 		case 'home':
        		$generalController->displayHome();
        		break;

        	case 'showForum':
        		$forumController->displayForum();
        		break;

        	case 'ShowTopic':
        		$forumController->displayTopic();
        		break;

        	case 'portfolio':
        		$generalController->displayPortfolio();
        		break;

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

