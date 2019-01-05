<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Modifier match</title>
</head>
<body style="color:black; background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg); background-repeat:no-repeat;">
<?php
require('lib.php');
require('header.php');
$linkpdo = connecterPDO();
?>
<div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;"> <?php
    //Variables pour remplir le formulaire :
    $id = sécurisationVariable($_GET['ID']);

    //Requête de modification
    if (isset($_POST['Ajouter'])) {
        if (($_POST['jt'] == -1) || ($_POST['jm'] == -1) || ($_POST['jp'] == -1) || ($_POST['r1'] == -1) || ($_POST['r2'] == -1) || ($_POST['r3'] == -1)) { ?>
            <br><h5 style="color: red">Veuillez renseigner tout les joueurs afin de constituer une équipe complète</h5>
            <?php
            formulaireMatch("ajouterMatch.php", $_POST, "Ajouter");
        } elseif (($_POST['jt'] == $_POST['jm']) || ($_POST['jt'] == $_POST['jp']) || ($_POST['jt'] == $_POST['r1']) || ($_POST['jt'] == $_POST['r2']) || ($_POST['jt'] == $_POST['r3']) || ($_POST['jm'] == $_POST['jp']) || ($_POST['jm'] == $_POST['r1']) || ($_POST['jm'] == $_POST['r2']) || ($_POST['jm'] == $_POST['r3']) || ($_POST['jp'] == $_POST['r1']) || ($_POST['jp'] == $_POST['r2']) || ($_POST['jp'] == $_POST['r3']) || ($_POST['r1'] == $_POST['r2']) || ($_POST['r1'] == $_POST['r3']) || ($_POST['r2'] == $_POST['r3'])) { ?>
            <br><h5 style="color: red">Vous avez selectionné plusieurs fois le même joueur</h5>

            <?php
            formulaireMatch("ajouterMatch.php", $_POST, "Ajouter");
        } else {
            $reqModif = $linkpdo->prepare("UPDATE rencontre SET DateRencontre=:d, LieuRencontre =:l, EquipeAdverse=:ea WHERE IdRencontre=:id");
            $reqModif->execute(array('d' => sécurisationVariable($_POST['DateR']),
                'l' => sécurisationVariable($_POST['Lieu']),
                'ea' => sécurisationVariable($_POST['Adversaire']),
                'id' => sécurisationVariable($_GET['ID'])));
            $reqModif->debugDumpParams();
            print_r($_POST);
            $reqModif = $linkpdo->prepare("UPDATE participertitulaire SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 1");
            $reqModif->execute(array('nl' => sécurisationVariable($_POST['jt']),
                'id' => sécurisationVariable($_GET['ID'])));
            $reqModif = $linkpdo->prepare("UPDATE participertitulaire SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 2");
            $reqModif->execute(array('nl' => sécurisationVariable($_POST['jm']),
                'id' => sécurisationVariable($_GET['ID'])));
            $reqModif = $linkpdo->prepare("UPDATE participertitulaire SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 3");
            $reqModif->execute(array('nl' => sécurisationVariable($_POST['jp']),
                'id' => sécurisationVariable($_GET['ID'])));
            $reqModif = $linkpdo->prepare("UPDATE participerremplacant SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 1");
            $reqModif->execute(array('nl' => sécurisationVariable($_POST['r1']),
                'id' => sécurisationVariable($_GET['ID'])));
            $reqModif = $linkpdo->prepare("UPDATE participerremplacant SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 2");
            $reqModif->execute(array('nl' => sécurisationVariable($_POST['r2']),
                'id' => sécurisationVariable($_GET['ID'])));
            $reqModif = $linkpdo->prepare("UPDATE participerremplacant SET NumLicence=:nl WHERE IdRencontre=:id AND Role = 3");
            $reqModif->execute(array('nl' => sécurisationVariable($_POST['r3']),
                'id' => sécurisationVariable($_GET['ID'])));

            echo "Match modifié";
        }
    } else {
        //Requête de recherche
        $reqRecherche = $linkpdo->prepare("SELECT * FROM rencontre WHERE IdRencontre = :id");
        $reqRecherche->execute(array('id' => $id));

        //Initialisation dans un tableau
        while ($data = $reqRecherche->fetch()) {
            $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 1");
            $reqSelectJ->execute(array('id' => $id));
            while ($dataJ = $reqSelectJ->fetch()) {
                $jt = $dataJ['NumLicence'];
            }

            $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 2");
            $reqSelectJ->execute(array('id' => $id));
            while ($dataJ = $reqSelectJ->fetch()) {
                $jm = $dataJ['NumLicence'];
            }
            $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 3");
            $reqSelectJ->execute(array('id' => $id));
            while ($dataJ = $reqSelectJ->fetch()) {
                $jp = $dataJ['NumLicence'];
            }
            $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 1");
            $reqSelectJ->execute(array('id' => $id));
            while ($dataJ = $reqSelectJ->fetch()) {
                $r1 = $dataJ['NumLicence'];
            }
            $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 2");
            $reqSelectJ->execute(array('id' => $id));
            while ($dataJ = $reqSelectJ->fetch()) {
                $r2 = $dataJ['NumLicence'];
            }
            $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 3");
            $reqSelectJ->execute(array('id' => $id));
            while ($dataJ = $reqSelectJ->fetch()) {
                $r3 = $dataJ['NumLicence'];
            }
            $tab = array('NumLicence' => $data['NumLicence'],
                'DateR' => $data['DateRencontre'],
                'Lieu' => $data['LieuRencontre'],
                'Adversaire' => $data['EquipeAdverse'],
                'jt' => $jt,
                'jm' => $jm,
                'jp' => $jp,
                'r1' => $r1,
                'r2' => $r2,
                'r3' => $r3);
        }
        formulaireMatch("modifierMatch.php?ID=$id", $tab, "Modifier");
    }
    ?>
</div>
</body>
</html>
