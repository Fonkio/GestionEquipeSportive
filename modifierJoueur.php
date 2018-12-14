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

    	//Requête de modification
        if(isset($_POST['Ajouter'])) {
        $reqModif=$linkpdo -> prepare ("UPDATE joueur SET Nom=:Nom, Prenom =:Prenom, DateDeNaissance=:Ddn, Taille=:Taille, Poids=:Poids, PostePref=:PostePref, Statut=:Statut WHERE NumLicence=:NumLicence");
        $reqModif->execute(array('Nom'=>$_POST['Nom'],
				                 'Prenom'=>$_POST['Prenom'],
                                 'Ddn'=>$_POST['Ddn'],
				                 'Taille'=>$_POST['Taille'],
				                 'Poids'=>$_POST['Poids'],
				                 'PostePref'=>$_POST['PostePref'],
				                 'Statut'=>$_POST['Statut'],
				                 'NumLicence'=>$_POST['NumLicence']));
	}

	//Requête de recherche
        $reqRecherche = $linkpdo->query("SELECT * FROM joueur WHERE NumLicence = $id");

	//Initialisation dans un tableau
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
	formulaire("modifierJoueur.php?NumLicence=$id", $tab, "Modifier");
    ?>
</body>
</html>
