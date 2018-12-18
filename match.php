<!DOCTYPE HTML>
<html lang="fr">
    <head>
		<title>Matchs</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	</head>
	<body>
	<?php
		require('header.php');
	?>
</br>
    <h2 style="text-align:center">Liste des matchs</h2></br>
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<!--<td>Photo</td>-->
				<th scope="col">Date</th>
				<th scope="col">Lieu</th>
				<th scope="col">Adversaire</th>
				<th scope="col">Score (Nous - Eux)</th>
                <th scope="col"> </th><!-- Truc pour supprimer-->

			</tr>
		</thead>
		<?php
			require('lib.php');
			$linkpdo=connecterPDO();?>
<form method=POST action="">
    <?php
			//Préparation de la requête
			$res = $linkpdo->prepare('SELECT * FROM rencontre');
			$res->execute(array());
			while(($data = $res->fetch())) {?>
			<tr>
				<td><?php echo"$data[1]"?></td>
				<td><?php echo"$data[2]"?></td>
				<td><?php echo"$data[3]"?></td>
				<td><?php
					if(is_null($data[4])&&is_null($data[5])){
						echo ("Trouver un moy rentrer score");
					} else
						echo("$data[4] - $data[5]");
					?>
                <td><a href=<?php echo "supprimerMatch.php?IdMatch=$data[0]";?>>Supprimer</a></td>
			</tr>
        </form>
			<?php }
			
			//On ferme le curseur
			$res->closeCursor();
		?>

		</table>
    <a style="background-color: #818181;" class="btn btn-secondary btn-lg btn-block" href="ajouterMatch.php" role="button">Ajouter match</a>	<!-- Création du tableau-->
    </body>
</html>
