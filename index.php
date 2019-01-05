<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Accueil</title>
</head>
<body style="color:black; background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg); background-repeat:repeat;">
<div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;">
    <h1 style="text-align:center;">Statistiques</h1>
<?php
    require('header.php');
    require('lib.php');
    $linkpdo = connecterPDO();

    //Requête pour le nombre total de matchs joués
    $reqRechercheTotal = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null");
    $reqRechercheTotal -> execute();
    while ($data = $reqRechercheTotal -> fetch()) {
        $nbMatchTotal=$data['count(*)'];
    }

    //Requête pour le nombre de victoire
    $reqRechercheWin = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null AND ResultatEquipe > ResultatAdverse");
    $reqRechercheWin -> execute();
    while ($data = $reqRechercheWin -> fetch()) {
        $nbMatchWin=$data['count(*)'];
    }

    //Requête pour le nombre de nuls
    $reqRechercheNul = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null AND ResultatEquipe = ResultatAdverse");
    $reqRechercheNul -> execute();
    while ($data = $reqRechercheNul -> fetch()) {
        $nbMatchNul=$data['count(*)'];
    }

    //Requête pour le nombre de lose
    $reqRechercheLose = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null AND ResultatEquipe < ResultatAdverse");
    $reqRechercheLose -> execute();
    while ($data = $reqRechercheLose -> fetch()) {
        $nbMatchLose=$data['count(*)'];
    }

    //Calcul des pourcentages :
    $prctWin = ($nbMatchWin/$nbMatchTotal)*100;
    $prctNul = ($nbMatchNul/$nbMatchTotal)*100;
    $prctLose = ($nbMatchLose/$nbMatchTotal)*100;
?>
    <h2>Nombre match : <?php echo $nbMatchTotal;?> </h2>
    <h2>Nombre de victoires : <?php echo $nbMatchWin." (".$prctWin."%)"; ?> </h2>
    <h2>Nombre de nuls : <?php echo $nbMatchNul." (".$prctNul."%)"; ?> </h2>
    <h2>Nombre de perdus : <?php echo $nbMatchLose." (".$prctLose."%)"; ?> </h2>
</div>
</body>
</html>

