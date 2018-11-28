<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
	<body>
		<?php 
			require('header.php');//Récupération du header
			require('lib.php');//Connexion à la BDD
			$linkpdo=connecterPDO();

			$reqAjout = $linkpdo->prepare('INSERT INTO joueur(NumLicence, Nom, Prenom, DateDeNaissance, Taille, Poids, PostePref,Statut) VALUES(:NumLicence, :Nom, :Prenom, :DateDeNaissance, :Taille, :Poids, :PostePref, :Statut)');
	
			$reqAjout->execute(array('NumLicence'=>$numLicence,
					'Nom'=>$nom,
					'Prenom'=>$prenom,
					'DateDeNaissance'=>$ddn,
					'Taille'=>$taill,
					'Poids'=>$poids,
					'PostePref'=>$postePref,
					'Statut'=>$statut));
		?>
	</body>
</html>
