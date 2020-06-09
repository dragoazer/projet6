<?php
	namespace Projet6\Model;
	/**
	 * 
	 */
	class Manager 
	{
		protected function dbConnect()
		{
				try {
					$bdd = new \PDO('mysql:host=127.0.0.1;dbname=projet6;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
				}	
				catch(Exception $e) {
					die('Erreur : '.$e->getMessage());
				}
				return $bdd;
		}
	}	
	