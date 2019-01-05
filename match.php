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
	<body style="color:black;
                background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg);
                background-repeat:no-repeat;">
	<?php
		require('header.php');
		require('lib.php');
	?>
	<div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;">
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
				<th scope="col"> </th><!-- Truc pour plus info-->
                <th scope="col"> </th><!-- Truc pour modifier score-->

			</tr>
		</thead>
		<?php
			$linkpdo=connecterPDO();
			//Préparation de la requête
			$res = $linkpdo->prepare('SELECT * FROM rencontre');
			$res->execute(array());
			while(($data = $res->fetch())) {?>

			<tr bgcolor="<?php if(!is_null($data[4])){
									if($data[4]<$data[5]){
										echo('#F96363') ;
									} else {
										if($data[4]>$data[5]){
											echo('#80F67C');
										} else
										if($data[4]==$data[5]){
											echo('#F8A667');
										}
									}
								}?>">
				<td><?php echo"$data[1]"?></td>
				<td><?php echo"$data[2]"?></td>
				<td><?php echo"$data[3]"?></td>
				<td><?php
					if(is_null($data[4])&&is_null($data[5])){
						?>
						<a href="ajouterScoreMatch.php?ID=<?php echo($data[0]); ?>"><button type="button" class="btn btn-primary">
							Ajouter un score
						</button></a>
						<?php
					} else
						echo("$data[4] - $data[5]");
					?>
					<td><a href=<?php echo "plusInfoMatch.php?ID=$data[0]";?>><button type="button" class="btn btn-primary">Plus d'info</button></a></td>
                <td><a href=<?php echo "supprimerMatch.php?ID=$data[0]";?>><button type="button" class="btn btn-primary">Supprimer</button></a></td>
			</tr>
        </form>
			<?php }
			
			//On ferme le curseur
			$res->closeCursor();
		?>

		</table>
    <a style="background-color: #818181;" class="btn btn-secondary btn-lg btn-block" href="ajouterMatch.php" role="button">Ajouter match</a>
</div>
</body>
</html>
