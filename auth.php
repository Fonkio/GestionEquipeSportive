<!DOCTYPE HTML>
<html lang="fr">
    <head>
	     <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Se connecter</title>
    </head>
	<body>
        <div class="PetiteDivCentre">
		    <?php
				require('lib.php');//Appel connexion BBD
				$linkpdo=connecterPDO();

				function auth() {
				    ?>
                    <!-- Le formulaire -->
                    <form action="" method="post" class="needs-validation">
                        <h4>Se connecter</h4></br>
                        <div class="form-row" style="margin: auto; text-align: center">
                            <div class="col-md-10 mb-3" style="text-align: center; margin: auto">
                                <label for="validationCustom01">Identifiant</label>
                                <input type="text" name="login" class="form-control" id="validationCustom01" placeholder="Identifiant" required>
                                <div class="invalid-feedback">
                                    Veuillez rentrer un identifiant.
                                </div>
                            </div>
                        </div>
                        <div class="form-row" style="margin: auto">
                            <div class="col-md-10 mb-3" style="margin: auto; text-align: center">
                                <label for="validationCustom01">Mot de passe</label>
                                <input type="password" name="mdp" class="form-control" id="validationCustom02" placeholder="Mot de passe" required>
                                <div class="invalid-feedback">
                                    Veuillez rentrer un mot de passe.
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" name="op">Se connecter</button>
                    </form>
                    <?php
                }

				//Si les variables sessions sont vides
				if(empty($_SESSION['login']) || empty($_SESSION['mdp'])) {
                    if (isset($_POST['op'])) {
                        if (empty($_POST['login']) && empty($_POST['mdp'])) {//Si les variables formulaires sont vides
                            auth();
                        } elseif ($_POST['login'] != $login_valide) {//Si le login est faux on redirige
                            auth();
                            ?> <h5 style="color: red">Identifiant incorrect</h5> <?php
                        } elseif (!comparerMdp($_POST['mdp'], $mdp_valide)) {//Si le mot de passe est faux on redirige
                            auth();
                            ?> <h5 style="color: red">Mot de passe incorrect</h5> <?php
                        } else {//Si tout est bon on enregistre
                            $_SESSION['login'] = $_POST['login'];
                            $_SESSION['mdp'] = rechercheMdp();
                            //creerJeton();
                            header('Location: index.php');
                        }
                    }
                    else {
                        auth();
                    }
                }
		    ?>
        </div>
	</body>
</html>
