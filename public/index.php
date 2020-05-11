<?php
	session_start();
	
	require_once "../vendor/autoload.php";

	use Projet6\Controller\GeneralController;

	$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
	$twig = new \Twig\Environment($loader, [
	]);
	$generalController = new GeneralController();

	
	if (isset($_GET["action"])) {
	 	switch ($_GET["action"]) {
	 		case 'home':
        		$generalController->displayHome($twig);
        		break;
	 	}
	} else {
    	$generalController->displayHome($twig);
    }

