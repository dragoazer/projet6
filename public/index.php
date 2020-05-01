<?php
	session_start();
	require "../vendor/autoload.php";

	use projet6\Controller\GeneralController;

	$generalController = new GeneralController();

	if (isset($_GET["action"])) {
	 	switch ($_GET["action"]) {
	 		case 'home':
        		$generalController->displayHome();
        		break;
	 	}
	} else {
    	$generalController->displayHome();
    }