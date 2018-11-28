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
			require('lib.php');
			$linkpdo=connecterPDO();
			require('header.php');
		?>
		<form>
			Numéro de licence : <input type="number" name="NumLicence"><br>
			Nom : <input type="text" name="Nom"><br>
			Prénom : <input type="text" name="Prenom"><br>
			Date de naissance : <input type="date" name="DateDeNaissance"><br>
			Taille (en cm) : <input type="number" name="Taille"><br>
			Poids (en Kg) : <input type="number" name="Poids"><br>
			Poste favoris : 
			<select>
				<option value="1">Tireur</option>
				<option value="2">Millieu</option>
				<option value="3">Pointeur</option>
			</select><br>
			Statut :
			<select>
				<option value="1">Actif</option>
				<option value="2">Blessé</option>
				<option value="3">Suspendu</option>
				<option value="4">Absent</option>
			</select>

		</form>
	</body>
</html>