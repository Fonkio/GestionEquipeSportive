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
	<body style="color:black;
                background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg);
                background-size: 100%;
                background-repeat:no-repeat;">



<div class="" style="margin-left: 30%; margin-right: 30%; width: 40%;">
		<?php
				//Variables pour vérifier le login et le mdp. A mettre dans une BDD après

				require('lib.php');//Appel connexion BBD
				$linkpdo=connecterPDO();

				//Si les variables sessions sont vides
				if(empty($_SESSION['login']) || empty($_SESSION['mdp'])) {
                    if (empty($_POST['login']) && empty($_POST['mdp'])) {//Si les variables formulaires sont vides

                        ?>
                        <form action="" method="post" class="needs-validation" style="margin-top: 100px; padding-top: 20px;padding-left: 40px;padding-bottom: 40px; background-color: white; border-radius: 10px;">
                        <h4>Se connecter</h4></br>
                        <div class="">
                            <div class="col-md-10 mb-3">
                                <label for="validationCustom01">Identifiant</label>
                                <input type="text" name="login" class="form-control" id="validationCustom01" placeholder="Login" required>
                                <div class="invalid-feedback">
                                    Veuillez rentrer un identifiant.
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="col-md-10 mb-3">
                                <label for="validationCustom01">Mot de passe</label>
                                <input type="password" name="mdp" class="form-control" id="validationCustom02" required>
                                <div class="invalid-feedback">
                                    Veuillez rentrer un mot de passe.
                                </div>
                            </div>
                        </div>
                            <button class="btn btn-primary" type="submit" name="op">Se connecter</button>
                        </form>

                        <?php
                    //Si le login est faux
                    }
                    elseif ($_POST['login'] != $login_valide) {
                        header('Location: authErrLogin.php');
                    } 
                    elseif ($_POST['mdp'] != $mdp_valide) {
                        header('Location: authErrMdp.php');
                    } else {
                        $_SESSION['login'] = $_POST['login'];
                        $_SESSION['mdp'] = $_POST['mdp'];
                        creerJeton();
                        header('Location: index.php');
                    }
                }
		?>
    </div>
	</body>
</html>
