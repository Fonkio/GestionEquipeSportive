<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Ajouter un joueur</title>
    </head>
    <body>

        <?php
            require('header.php'); //Affichage en-tête
            require('lib.php'); //Connexion SQL + fonctions
            $tab = array();
        ?>

        <div class="DivPage">

            <?php
            //Vérification si le formulaire à bien été rempli
            if ((   empty($_POST['NumLicence']) || empty($_POST['Nom']) ||
                    empty($_POST['Prenom']) || empty($_POST['Ddn']) ||
                    empty($_POST['Taille']) || empty($_POST['Poids']) ||
                    empty($_POST['PostePref']) || empty($_POST['Statut'])) && isset($_POST['Ajouter'])) { //Si tout n'est pas rempli et que l'on a validé le formulaire

                echo("Veuillez renseigner tout les champs du formulaire correctement");
                formulaire("ajouterJoueur.php", $tab, "Ajouter"); //Affichage formulaire joueur
            }
            else { //Sinon
                if (isset($_POST['Ajouter'])) { //Si tout rempli et validé

                    //Connexion à la BDD
                    $linkpdo = connecterPDO();

                    //Recup des variables
                    $numLicence = sécurisationVariable($_POST['NumLicence']);

                    //Préparation requête pour vérifier si le joueur est déjà, ou non, dans la BDD
                    $reqList = $linkpdo->prepare("SELECT Nom FROM joueur WHERE NumLicence = :nl");

                    $tab_param = array('nl' => $numLicence);
                    $reqList->execute($tab_param);
                    $nb = $reqList->rowCount();//Pour vérifier qu'il n'y a aucun joueur qui correspond

                    //Affectation des variables
                    if ($nb == 0) { //Aucun résultat (on l'ajoute)
                        $numLicence = sécurisationVariable($_POST['NumLicence']);
                        $nom = sécurisationVariable($_POST['Nom']);
                        $prenom = sécurisationVariable($_POST['Prenom']);
                        $ddn = sécurisationVariable($_POST['Ddn']);
                        $taille = sécurisationVariable($_POST['Taille']);
                        $poids = sécurisationVariable($_POST['Poids']);
                        $postePref = sécurisationVariable($_POST['PostePref']);
                        $statut = sécurisationVariable($_POST['Statut']);

                        $linkpdo = connecterPDO(); //Connexion bdd

                        //Préparation requête ajout
                        $reqAjout = $linkpdo->prepare("INSERT INTO joueur (NumLicence, Nom, Prenom, DateDeNaissance, Taille, Poids, PostePref, Statut) 
                                                               VALUES (:NumLicence, :Nom, :Prenom, :DateDeNaissance, :Taille, :Poids, :PostePref, :Statut)");

                        //Exécution requête ajout
                        $tab_param = array('NumLicence' => $numLicence,
                            'Nom' => $nom,
                            'Prenom' => $prenom,
                            'DateDeNaissance' => $ddn,
                            'Taille' => $taille,
                            'Poids' => $poids,
                            'PostePref' => $postePref,
                            'Statut' => $statut);
                        $reqAjout->execute($tab_param);

                        echo("Le joueur $nom $prenom a bien été ajouté<br/>");
                        ?>
                        <br/>
                        <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
                        <?php
                    } //Un ou plusieurs résultats (on ne l'ajoute pas)
                    else {
                        echo("Le joueur existe déjà (même numéro de licence)");
                        ?>
                        <br/>
                        <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
                        <?php
                    }
                } //Tant qu'on a pas cliqué sur "Ajouter", le formulaire reste affiché
                else {
                    formulaire("ajouterJoueur.php", $tab, "Ajouter");
                }
            }
            //Pour upload l'image
            if (isset($_FILES['Image'])) {
                $maxsize = $_POST['MAX_FILE_SIZE'];
                uploadImage($numLicence, $maxsize);
            }
            ?> </div>
    </body>
</html>
