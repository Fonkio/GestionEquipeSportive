<?php
	require('header.php');
	require('lib.php');
	if(!empty($_SESSION['login'])&&!empty($_SESSION['mdp'])){
		session_destroy();
	}
	header('Location: auth.php');

//date(Y-m-d,"strtotime($arg)")
?>
