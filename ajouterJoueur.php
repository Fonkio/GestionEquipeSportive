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
			$tab = array();

			if((empty($_POST['NumLicence'])||empty($_POST['Nom'])||empty($_POST['Prenom'])||empty($_POST['Ddn'])||empty($_POST['Taille'])||empty($_POST['Poids'])||empty($_POST['PostePref'])||empty($_POST['Statut']))&&isset($_POST['Ajouter'])){
				echo("Veuillez renseigner tout les champs du formulaire correctement");

				formulaire("ajouterJoueur.php",$tab);
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
						$numLicence=htmlentities($_POST['NumLicence'],ENT_QUOTES);
						$nom=htmlentities($_POST['Nom'],ENT_QUOTES);
						$prenom=htmlentities($_POST['Prenom'], ENT_QUOTES);
						$ddn=htmlentities($_POST['Ddn'],ENT_QUOTES);
						$taille=htmlentities($_POST['Taille'],ENT_QUOTES);
						$poids=htmlentities($_POST['Poids'],ENT_QUOTES);
						$postePref=htmlentities($_POST['PostePref'],ENT_QUOTES);
						$statut=htmlentities($_POST['Statut'],ENT_QUOTES);

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
                        <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
                        <?php
					}
					else {
						echo ("Le joueur existe déja (même numéro de licence)");
						?>
						<br/>
                        <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
						<?php
					}
				} 
				else {
					formulaire("ajouterJoueur.php",$tab, "Ajouter");
				}
			}
			
		?>
	</body>
</html>
