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
			function formul() {
				//BLOC Formulaire
				?>
				<form action ="ajouterJoueur.php" method="post">
					Numéro de licence * : <input type="number" name="NumLicence"><br>
					Nom * : <input type="text" name="Nom"><br>
					Prénom * : <input type="text" name="Prenom"><br>
					Date de naissance * : <input type="date" name="Ddn"><br>
					Taille (en cm) : <input type="number" name="Taille"><br>
					Poids (en Kg) : <input type="number" name="Poids"><br>
					Poste favoris * : 
					<select name='PostePref'>
						<option value="1">Tireur</option>
						<option value="2">Millieu</option>
						<option value="3">Pointeur</option>
					</select><br>
					Statut * :
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


			require('header.php');
			require('lib.php');
			//estLogin();
			
			if((empty($_POST['NumLicence'])||empty($_POST['Nom'])||empty($_POST['Prenom'])||empty($_POST['Ddn']))&&isset($_POST['Ajouter'])){
				echo("Veuillez renseigner tout les champs obligatoires (*)");
				formul();
			}
			else{
				//Vérification si les variables obligatoire sont nulles ou non
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
					print("$nb");

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
					formul();
				}
			}
			
		?>
	</body>
</html>
