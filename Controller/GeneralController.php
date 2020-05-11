<?php 
	namespace Projet6\Controller;

	class GeneralController 
	{

		public function displayHome ($twig) 
		{
			$template = $twig->load('accueil.php');
			echo $template->render([
				'css' =>'public\css\baseCss.css',
				'title' => 'Bievenue sur l\'accueil.',		
			]);
		}
	}