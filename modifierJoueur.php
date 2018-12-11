<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Modifier un joueur</title>
</head>
<body>
    <?php
        require('lib.php');
        require('header.php');
        estLogin();
        $linkpdo=connecterPDO();
	//Variables pour remplir le formulaire :
        $id=$_GET['NumLicence'];
	$_POST['NumLicence']=0;
	$_POST['Nom']=0;
	$_POST['Prenom']=0;
	$_POST['Ddn']=0;
	$_POST['Taille']=0;
	$_POST['Poids']=0;
        $reqRecherche = $linkpdo->prepare("SELECT * FROM joueur WHERE NumLicence = $id");
        $tab_param = array('id'=>$id);
      
	formulaire("modifierJoueur.php");
	while( $data=$reqRecherche->fetch();
    //Faire la requête de modification
    ?>
</body>
</html>
