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
<body style="color:black; background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg); background-repeat:no-repeat;">
    <?php
        require('lib.php');
        require('header.php');
        $linkpdo=connecterPDO(); ?><div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;"> <?php
	//Variables pour remplir le formulaire :
        $id=sécurisationVariable($_GET['NumLicence']);

    	//Requête de modification
        if(isset($_POST['Ajouter'])) {
        $reqModif = $linkpdo -> prepare("UPDATE joueur SET Nom=:Nom, Prenom =:Prenom, DateDeNaissance=:Ddn, Taille=:Taille, Poids=:Poids, PostePref=:PostePref, Statut=:Statut WHERE NumLicence=:NumLicence");
        $reqModif -> execute(array('Nom'=>sécurisationVariable($_POST['Nom']),
				                 'Prenom'=>sécurisationVariable($_POST['Prenom']),
                                 'Ddn'=>sécurisationVariable($_POST['Ddn']),
				                 'Taille'=>sécurisationVariable($_POST['Taille']),
				                 'Poids'=>sécurisationVariable($_POST['Poids']),
				                 'PostePref'=>sécurisationVariable($_POST['PostePref']),
				                 'Statut'=>sécurisationVariable($_POST['Statut']),
				                 'NumLicence'=>sécurisationVariable($_POST['NumLicence'])));
        echo "Joueur modifié";
	}

	//Requête de recherche
        $reqRecherche = $linkpdo -> prepare("SELECT * FROM joueur WHERE NumLicence = :id");
        $reqRecherche -> execute(array('id'=>$id));

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
</div>
</body>
</html>
