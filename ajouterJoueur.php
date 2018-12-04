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

			// //Vérification s'il est log
			// session_start();
			// if(empty($_SESSION['login'])){
			// 	header('Location: auth.php');//Redirection s'il ne l'est pas
			// }
			
			//Vérification si les variables obligatoire sont nulles ou non
			if(isset($_POST['Ajouter'])) {
				require('lib.php');
				$linkpdo=connecterPDO();
				
				//Préparation requête ajout
				$reqAjout = $linkpdo->prepare("SELECT Nom FROM joueur WHERE NumLicence = :nl");

				$tab_param = array('nl'=>$numLicence)
				$reqAjout->execute($tab_param);

				//!!!!! ICI !!!!!!!
				//JE DOIT VERIF SI LA REQUETE RENVOIE DES VALEURS

				if 
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
			} else {					
		?>
			

		<form action ="ajouterJoueur.php" method="post">
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
		<?php
		}
		?>
	</body>
</html>
