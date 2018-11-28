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
			$numLicence=0;
			$nom="m";
			$prenom="m";
			$ddn=0;//Continuer avec les autres variables
			//Vérification si les variables sont nulles ou non
			if(isset($_POST['numLicence']) && isset($_POST['Nom']) && isset($_POST['Prenom']) && isset($_POST['Ddn']))
			{
				$numLicence=$_POST['NumLicence'];
				$nom=$_POST['Nom'];
				$prenom=$_POST['Prenom'];
				$ddn=$_POST['Ddn'];
				$taille=$_POST['Taille'];
				$poids=$_POST['Poids'];
				$postePref=$_POST['PostePref'];
				$statut=$_POST['Statut'];
			}
			
			//print pour vérifier
			print_r($_POST);			

			require('lib.php');
			$linkpdo=connecterPDO();
			require('header.php');
				
			//Préparation requête ajout
			$reqAjout = $linkpdo->prepare('INSERT INTO joueur(NumLicence, Nom, Prenom, DateDeNaissance, Taille, Poids, PostePref,Statut) VALUES(:NumLicence, :Nom, :Prenom, :DateDeNaissance, :Taille, :Poids, :PostePref, :Statut)');

			//Exécution requête ajout
			$reqAjout->execute(array('NumLicence'=>$numLicence,
					'Nom'=>$nom,
					'Prenom'=>$prenom,
					'DateDeNaissance'=>$ddn,
					'Taille'=>$taille,
					'Poids'=>$poids,
					'PostePref'=>$postePref,
					'Statut'=>$statut));
		?>

		<form action ="" method="post">
			Numéro de licence : <input type="number" name="NumLicence"><br>
			Nom : <input type="text" name="Nom"><br>
			Prénom : <input type="text" name="Prenom"><br>
			Date de naissance : <input type="date" name="Ddn"><br>
			Taille (en cm) : <input type="number" name="Taille"><br>
			Poids (en Kg) : <input type="number" name="Poids"><br>
			Poste favoris : 
			<select name='PostePref'>
				<option value="1">Tireur</option>
				<option value="2">Millieu</option>
				<option value="3">Pointeur</option>
			</select><br>
			Statut :
			<select name='Statut'>
				<option value="1">Actif</option>
				<option value="2">Blessé</option>
				<option value="3">Suspendu</option>
				<option value="4">Absent</option>
			</select><br />
			<input type="submit" name="Ajouter">

		</form>
	</body>
</html>
