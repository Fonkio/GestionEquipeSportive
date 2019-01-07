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
        <title>Modifier un joueur</title>
    </head>
    <body>
        <?php
            require('header.php');
            require('lib.php');
            $linkpdo = connecterPDO(); //connexion bdd
        ?>
        <div class="DivPage"> <?php
            //Variables pour remplir le formulaire :
            $id = sécurisationVariable($_GET['NumLicence']);

            //Requête de modification
            if (isset($_POST['Ajouter'])) { //Si on clique sur ajouter
                $reqModif = $linkpdo->prepare("UPDATE joueur SET Nom=:Nom, Prenom =:Prenom, DateDeNaissance=:Ddn, Taille=:Taille, Poids=:Poids, PostePref=:PostePref, Statut=:Statut WHERE NumLicence=:NumLicence");
                $reqModif->execute(array('Nom' => sécurisationVariable($_POST['Nom']),
                    'Prenom' => sécurisationVariable($_POST['Prenom']),
                    'Ddn' => sécurisationVariable($_POST['Ddn']),
                    'Taille' => sécurisationVariable($_POST['Taille']),
                    'Poids' => sécurisationVariable($_POST['Poids']),
                    'PostePref' => sécurisationVariable($_POST['PostePref']),
                    'Statut' => sécurisationVariable($_POST['Statut']),
                    'NumLicence' => sécurisationVariable($_POST['NumLicence'])));
                echo "Joueur modifié";
            }

            //Requête de recherche
            $reqRecherche = $linkpdo->prepare("SELECT * FROM joueur WHERE NumLicence = :id");
            $reqRecherche->execute(array('id' => $id));

            //Initialisation dans un tableau
            while ($data = $reqRecherche->fetch()) {
                $tab = array('NumLicence' => $data['NumLicence'],
                    'Nom' => $data['Nom'],
                    'Prenom' => $data['Prenom'],
                    'Ddn' => $data['DateDeNaissance'],
                    'Taille' => $data['Taille'],
                    'Poids' => $data['Poids'],
                    'PostePref' => $data['PostePref'],
                    'Statut' => $data['Statut']);
            }
            //Apparition du formulaire de modification avec toutes les informations sur le joueur
            formulaire("modifierJoueur.php?NumLicence=$id", $tab, "Modifier");

            //Upload de l'image
            if (isset($_FILES['Image'])) {
                $maxsize = $_POST['MAX_FILE_SIZE'];
                uploadImage($id, $maxsize);
            }
            ?>
        </div>
    </body>
</html>
