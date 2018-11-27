<?php
	
	function connecterPDO(){
	require('../config.php');
		try {
			$linkpdo = new PDO("mysql:host=$host;dbname=$login",$server,$mdp);
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
		return $linkpdo;
	}
?>
