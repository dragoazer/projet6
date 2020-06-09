<?php
	namespace projet6\Controller;
	use projet6\Controller\GameForController;
	use projet6\Controller\MusicForController;
	use projet6\Controller\PoliticForController;

	/**
	   * 
	   */
	  class ForumController 
	  {
	  	
	  	public function displayTopic ()
	  	{
	  		if (isset($_GET['type']) AND !empty($_GET['type'])) {
		  		if ($_GET['type'] == "game") {
		  			$gameForController = new GameForController();
		  		} elseif ($_GET['type'] == "music") {
	        		$musicForController = new MusicForController();
		  		} elseif ($_GET['type'] == "politic") {
	        		$politicForController = new PoliticForController();
		  		} else {
		  			$this->displayAllForum();
		  		}
		  	}
	  	}

	  	public function displayForum ()
	  	{

	  	}
	  }  
