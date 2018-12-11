<!DOCTYPE HTML>
<html lang="fr">
    <head>
	     <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Ajouter un joueur</title>
    </head>
	<body>

		<?php
    		require('header.php');
			require('lib.php');
			estLogin();


			if((empty($_POST['NumLicence'])||empty($_POST['Nom'])||empty($_POST['Prenom'])||empty($_POST['Ddn'])||empty($_POST['Taille'])||empty($_POST['Poids'])||empty($_POST['PostePref'])||empty($_POST['Statut']))&&isset($_POST['Ajouter'])){
				echo("Veuillez renseigner tout les champs du formulaire");
				formulaire("ajouterJoueur.php");
			}
			else{
				if(isset($_POST['Ajouter'])) {
					
					//Connexion à la BDD
					$linkpdo=connecterPDO();

					//Recup des variables
					$numLicence=$_POST['NumLicence'];
					//Préparation requête ajout
					$reqList = $linkpdo->prepare("SELECT Nom FROM joueur WHERE NumLicence = :nl");

					$tab_param = array('nl'=>$numLicence);
					$reqList->execute($tab_param);
					$nb = $reqList->rowCount();

					if ($nb == 0) {
						$numLicence=$_POST['NumLicence'];
						$nom=$_POST['Nom'];
						$prenom=$_POST['Prenom'];
						$ddn=$_POST['Ddn'];
						$taille=$_POST['Taille'];
						$poids=$_POST['Poids'];
						$postePref=$_POST['PostePref'];
						$statut=$_POST['Statut'];

						$linkpdo=connecterPDO();
						
						//Préparation requête ajout
						$reqAjout = $linkpdo->prepare("INSERT INTO joueur (NumLicence, Nom, Prenom, DateDeNaissance, Taille, Poids, PostePref, Statut) 
													   VALUES (:NumLicence, :Nom, :Prenom, :DateDeNaissance, :Taille, :Poids, :PostePref, :Statut)");

						//Exécution requête ajout
						$tab_param = array('NumLicence'=>$numLicence,
						'Nom'=>$nom,
						'Prenom'=>$prenom,
						'DateDeNaissance'=>$ddn,
						'Taille'=>$taille,
						'Poids'=>$poids,
						'PostePref'=>$postePref,
						'Statut'=>$statut);
						$reqAjout->execute($tab_param);
						echo("Le joueur $nom $prenom a bien été ajouté<br/>");
						?>
						<br/>
						<a href="ajouterJoueur.php"> <button>< Retour</button></a>
						<?php
					}
					else {
						echo ("Le joueur existe déja (même numéro de licence)");
						?>
						<br/>
						<a href="ajouterJoueur.php"> <button>< Retour</button></a>
						<?php
					}
				} 
				else {
					formulaire("ajouterJoueur.php");
				}
			}
			
		?>
	</body>
</html>
