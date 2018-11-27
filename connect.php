<?php 
try {
		$linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
	}
///Capture des erreurs éventuelles
catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
}
 ?>