<?php
	require('header.php');
	if(!empty($_SESSION['login'])&&!empty($_SESSION['mdp'])){
		session_destroy();
	}
	header('Location: auth.php');
?>
