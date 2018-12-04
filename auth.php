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
				//Variables pour vérifier le login et le mdp. A mettre dans une BDD après
				$login_valide='lapin';
				$psswd_valide='canard';

				require('lib.php');//Appel connexion BBD
				$linkpdo=connecterPDO();
				require('header.php');//Header CSS

				//Si les variables sessions sont vides
				if(empty($_SESSION['login']) || empty($_SESSION['mdp'])) {
                    if (empty($_POST['login']) && empty($_POST['mdp'])) {//Si les variables formulaires sont vides

                        ?>
                        <form action="" method="post">
                            Login <input type="text" name="login"/>
                            Mot de passe <input type="password" name="mdp"/>
                            <input name="op" type="submit" value="Valider"/>
                        </form>
                        <?php
                    } //Si le login est faux
                    elseif ($_POST['login'] != $login_valide) {
                        header('Location: authErrLogin.php');
                    } elseif ($_POST['mdp'] != $psswd_valide) {
                        header('Location: authErrMdp.php');
                    } else {
                        session_start();
                        $_SESSION['login'] = $_POST['login'];
                        $_SESSION['mdp'] = $_POST['mdp'];
                        header('Location: accueil.php');
                    }
                }
		?>
	</body>
</html>
