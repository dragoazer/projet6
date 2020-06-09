<?php 
	namespace Projet6\Controller;

	class GeneralController 
	{
		private $twig;

		public function __construct ()
		{
			$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/projet6/template');
			$this->twig = new \Twig\Environment($loader);
		}

		public function displayHome () 
		{

			$template = $this->twig->load('accueil.html');
			echo $template->render([
				'title' => 'Bienvenue sur l\'accueil.',
				'css' =>'/projet6/public/css/baseCss.css',
				'js' =>'/projet6/public/js/homeParallax.js'
			]);
		}
	}