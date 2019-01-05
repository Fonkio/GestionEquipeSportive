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
        $reqModif = $linkpdo->prepare("UPDATE rencontre SET DateRencontre=:d, LieuRencontre =:l, EquipeAdverse=:ea, ResultatEquipe=:rn, ResultatAdverse=:ra WHERE IdRencontre=:id");
        $reqModif->execute(array('Nom' => sécurisationVariable($_POST['Nom']),
            'd' => sécurisationVariable($_POST['Prenom']),
            'l' => sécurisationVariable($_POST['Ddn']),
            'ea' => sécurisationVariable($_POST['Taille']),
            'rn' => sécurisationVariable($_POST['Poids']),
            'ra' => sécurisationVariable($_POST['ra']),
            'id' => sécurisationVariable($_GET['ID'])));
        echo "Match modifié";
    }

    //Requête de recherche
    $reqRecherche = $linkpdo->prepare("SELECT * FROM rencontre WHERE IdRencontre = :id");
    $reqRecherche->execute(array('id' => $id));

    //Initialisation dans un tableau
    while ($data = $reqRecherche->fetch()) {
        $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 1");
        $reqSelectJ->execute(array('id' => $id));
        while($dataJ=$reqSelectJ->fetch()){
            $jt = $dataJ['NumLicence'];
        }
        $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 2");
        $reqSelectJ->execute(array('id' => $id));
        while($dataJ=$reqSelectJ->fetch()){
            $jm = $dataJ['NumLicence'];
        }
        $reqSelectJ = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id AND Role = 3");
        $reqSelectJ->execute(array('id' => $id));
        while($dataJ=$reqSelectJ->fetch()){
            $jp = $dataJ['NumLicence'];
        }
        $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 1");
        $reqSelectJ->execute(array('id' => $id));
        while($dataJ=$reqSelectJ->fetch()){
            $r1 = $dataJ['NumLicence'];
        }
        $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 2");
        $reqSelectJ->execute(array('id' => $id));
        while($dataJ=$reqSelectJ->fetch()){
            $r2 = $dataJ['NumLicence'];
        }
        $reqSelectJ = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id AND Role = 3");
        $reqSelectJ->execute(array('id' => $id));
        while($dataJ=$reqSelectJ->fetch()){
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

    ?>
</div>
</body>
</html>
