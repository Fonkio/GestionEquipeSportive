<!DOCTYPE HTML>
<html lang="fr">
    <head>
	     <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Se connecter</title>
    </head>
	<body>

		<?php
			require('lib.php');
			$linkpdo=connecterPDO();
			require('header.php');
			session_start();

			if(empty($_SESSION['login']) || empty($_SESSION['mdp'])){
				if(empty($_POST['login']) && empty($_POST['mdp'])){
		?>
					<form action="session.php" method="post">
						Login <input type="text" name="login"/>
						Mot de passe <input type="password" name="mdp"/>
						<input name="op" type="submit" value="Valider"/>
					</form>
		<?php
				}
				else {
					$_SESSION['login'] = $_POST['login'];;
					$_SESSION['mdp'] = $_POST['mdp'];
				}
			}
		?>
	</body>
</html>
