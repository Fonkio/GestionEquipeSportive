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
        <title>Modifier match</title>
    </head>
    <body>
        <?php
            require('lib.php');
            require('header.php'); //en-tête
            $linkpdo = connecterPDO(); //connexion SQL
        ?>
        <div class="DivPage"> <?php
            //Variables pour remplir le formulaire :
            $id = sécurisationVariable($_GET['ID']);

            //verif validation formulaire
            if (isset($_POST['Ajouter'])) { // OUI

                if (($_POST['jt'] == -1)||($_POST['jm'] == -1)||($_POST['jp']== -1)) { //Verif selection de tout les joueurs
                    ?>
                        <br><h5 style="color: red">Veuillez renseigner tout les joueurs afin de constituer une équipe complète</h5>
                    <?php
                    formulaireMatch("ajouterMatch.php", $_POST, "Ajouter"); //Affichage formulaire

                } //Verif sélection 2 fois le même joueur
                elseif (( $_POST['jt'] == $_POST['jm'])||($_POST['jt'] == $_POST['jp'])||
                    ($_POST['jt'] == $_POST['r1'])||($_POST['jt'] == $_POST['r2'])||
                    ($_POST['jt'] == $_POST['r3'])||($_POST['jm'] == $_POST['jp'])||
                    ($_POST['jm'] == $_POST['r1'])||($_POST['jm'] == $_POST['r2'])||
                    ($_POST['jm'] == $_POST['r3'])||($_POST['jp'] == $_POST['r1'])||
                    ($_POST['jp'] == $_POST['r2'])||($_POST['jp'] == $_POST['r3'])||
                    (($_POST['r1'] == $_POST['r2'])&&(!$_POST['r1'] == -1))||(($_POST['r1'] == $_POST['r3'])&&(!$_POST['r1'] == -1))||
                    (($_POST['r2'] == $_POST['r3'])&&(!$_POST['r2'] == -1))) {
                    ?>
                        <br><h5 style="color: red">Vous avez selectionné plusieurs fois le même joueur</h5>
                    <?php
                    formulaireMatch("ajouterMatch.php", $_POST, "Ajouter"); //Affichage formulaire
                }
                else { // Tout les joueurs son sel et pas de doubles

                    //MAJ info du match
                    $reqModif = $linkpdo->prepare("UPDATE rencontre SET DateRencontre=:d, LieuRencontre =:l, EquipeAdverse=:ea, Heure=:h WHERE IdRencontre=:id");
                    $reqModif->execute(array('d' => sécurisationVariable($_POST['DateR']),
                        'l' => sécurisationVariable($_POST['Lieu']),
                        'h' => sécurisationVariable($_POST['Heure']),
                        'ea' => sécurisationVariable($_POST['Adversaire']),
                        'id' => sécurisationVariable($_GET['ID'])));

                    //MAJ Titulaire tireur
                    $reqModif = $linkpdo->prepare("UPDATE participertitulaire SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 1");
                    $reqModif->execute(array('nl' => sécurisationVariable($_POST['jt']),
                        'id' => sécurisationVariable($_GET['ID'])));

                    //MAJ Titulaire milieu
                    $reqModif = $linkpdo->prepare("UPDATE participertitulaire SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 2");
                    $reqModif->execute(array('nl' => sécurisationVariable($_POST['jm']),
                        'id' => sécurisationVariable($_GET['ID'])));

                    //MAJ Titulaire pointeur
                    $reqModif = $linkpdo->prepare("UPDATE participertitulaire SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 3");
                    $reqModif->execute(array('nl' => sécurisationVariable($_POST['jp']),
                        'id' => sécurisationVariable($_GET['ID'])));

                    //MAJ Remplacant tireur
                    $reqModif = $linkpdo->prepare("UPDATE participerremplacant SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 1");
                    $reqModif->execute(array('nl' => sécurisationVariable($_POST['r1']),
                        'id' => sécurisationVariable($_GET['ID'])));

                    //MAJ Remplacant milieu
                    $reqModif = $linkpdo->prepare("UPDATE participerremplacant SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 2");
                    $reqModif->execute(array('nl' => sécurisationVariable($_POST['r2']),
                        'id' => sécurisationVariable($_GET['ID'])));

                    //MAJ Remplacant pointeur
                    $reqModif = $linkpdo->prepare("UPDATE participerremplacant SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 3");
                    $reqModif->execute(array('nl' => sécurisationVariable($_POST['r3']),
                        'id' => sécurisationVariable($_GET['ID'])));

                    header('Location: match.php'); //Redirection vers match
                }
            }
            else {

                //Recherche du match selectionné
                $reqRecherche = $linkpdo->prepare("SELECT * FROM rencontre WHERE IdRencontre = :id");
                $reqRecherche->execute(array('id' => $id));
                while ($data = $reqRecherche->fetch()) {

                    //Sélection titulaire tireur
                    $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 1");
                    $reqSelectJ->execute(array('id' => $id));
                    while ($dataJ = $reqSelectJ->fetch()) {
                        $jt = $dataJ['NumLicence'];
                    }

                    //Sélection titulaire milieu
                    $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 2");
                    $reqSelectJ->execute(array('id' => $id));
                    while ($dataJ = $reqSelectJ->fetch()) {
                        $jm = $dataJ['NumLicence'];
                    }

                    //Sélection titulaire pointeur
                    $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 3");
                    $reqSelectJ->execute(array('id' => $id));
                    while ($dataJ = $reqSelectJ->fetch()) {
                        $jp = $dataJ['NumLicence'];
                    }

                    //Sélection remplaçant tireur
                    $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 1");
                    $reqSelectJ->execute(array('id' => $id));
                    while ($dataJ = $reqSelectJ->fetch()) {
                        $r1 = $dataJ['NumLicence'];
                    }

                    //Sélection remplaçant milieu
                    $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 2");
                    $reqSelectJ->execute(array('id' => $id));
                    while ($dataJ = $reqSelectJ->fetch()) {
                        $r2 = $dataJ['NumLicence'];
                    }

                    //Sélection remplaçant pointeur
                    $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 3");
                    $reqSelectJ->execute(array('id' => $id));
                    while ($dataJ = $reqSelectJ->fetch()) {
                        $r3 = $dataJ['NumLicence'];
                    }

                    //Ajout des données dans un tableau
                    $tab = array(
                        'DateR' => $data['DateRencontre'],
                        'Lieu' => $data['LieuRencontre'],
                        'Adversaire' => $data['EquipeAdverse'],
                        'Heure' => $data['Heure'],
                        'jt' => $jt,
                        'jm' => $jm,
                        'jp' => $jp,
                        'r1' => $r1,
                        'r2' => $r2,
                        'r3' => $r3);
                } //Fin while

                formulaireMatch("modifierMatch.php?ID=$id", $tab, "Modifier"); //affichage du formulaire avec les données actuelles du match
            } ?>
        </div>
    </body>
</html>
