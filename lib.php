<?php
	
	function connecterPDO(){
	require('../config.php');
		try {
			$linkpdo = new PDO("mysql:host=$host;dbname=$dbname",$login,$mdp);
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
		return $linkpdo;
	}
?>
