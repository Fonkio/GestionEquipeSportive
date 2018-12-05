<!DOCTYPE HTML>
<html lang="fr">
    <head>
	     <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Accueil</title>
    </head>
	<body>
	<?php
		require('header.php');
	?>
	<h2>Joueurs présents :</h2>
	<!-- Création du tableau-->
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<!--<td>Photo</td>-->
				<th scope="col">Numéro de licence</th>
				<th scope="col">Nom</th>
				<th scope="col">Prénom</th>
				<th scope="col">Taille</th>
				<th scope="col">Poids</th>
				<th scope="col">Poste préféré</th>
				<th scope="col"></th><!-- Truc pour modifier-->
				<th scope="col"></th><!-- Truc pour supprimer-->
				<!--<td>Commentaire</td>
				<td>Evaluation</td>-->
			</tr>
		</thread>
		<tbody>
		<?php
			require('lib.php');
			$linkpdo=connecterPDO();

			//Préparation de la requête
			$res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur');
			$res->execute(array());
			while(($data = $res->fetch())) {?>
			<tr>
				<td><?php echo"$data[0]"?></td>
				<td><?php echo"$data[1]"?></td>
				<td><?php echo"$data[2]"?></td>
				<td><?php echo"$data[3]"?></td>
				<td><?php echo"$data[4]"?></td>
				<td><?php echo"$data[5]"?></td>
				<td><a href="ajouterJoueur.php">Modifier</a></td>
				<td><a href="supprimerJoueur.php">Supprimer</a></td>
			</tr>
			
			<?php }
			
			//On ferme le curseur
			$res->closeCursor();
		?>
			</tbody>
		</table>
	</body>
</html>
