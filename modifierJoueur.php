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
        $linkpdo=connecterPDO();
	//Variables pour remplir le formulaire :
        $id=$_GET['NumLicence'];
        $reqRecherche = $linkpdo->query("SELECT * FROM joueur WHERE NumLicence = $id");
      	while($data=$reqRecherche->fetch()){
		$tab = array('NumLicence' => $data['NumLicence'],
			     'Nom' => $data['Nom'],
			     'Prenom' => $data['Prenom'],
			     'Ddn' => $data['DateDeNaissance'],
			     'Taille' => $data['Taille'],
			     'Poids' => $data['Poids'],
			     'PostePref' => $data['PostePref'],
			     'Statut' => $data['Statut']);
	}
	formulaire("modifierJoueur.php", $tab, "Modifier");
    //Faire la requête de modification
    ?>
</body>
</html>
