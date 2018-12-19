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
					$numLicence=sécurisationVariable($_POST['NumLicence']);
					//Préparation requête ajout
					$reqList = $linkpdo->prepare("SELECT Nom FROM joueur WHERE NumLicence = :nl");

					$tab_param = array('nl'=>$numLicence);
					$reqList->execute($tab_param);
					$nb = $reqList->rowCount();

					if ($nb == 0) {
						$numLicence=sécurisationVariable($_POST['NumLicence']);
						$nom=sécurisationVariable($_POST['Nom']);
						$prenom=sécurisationVariable($_POST['Prenom']);
						$ddn=sécurisationVariable($_POST['Ddn']);
						$taille=sécurisationVariable($_POST['Taille']);
						$poids=sécurisationVariable($_POST['Poids']);
						$postePref=sécurisationVariable($_POST['PostePref']);
						$statut=sécurisationVariable($_POST['Statut']);

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
			
			//Upload d'image
			$image_sizes = array( '1024','576'); //Caler la taille de l'image ici, car là c'est un peut comme 1=1
			$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
			$maxsize="100000"; //Récupérer le hidden 
			$maxwidth="1024";
			$maxheight="576";
			
			if(isset($_FILES['Image'])){
				if ($_FILES['Image']['error'] > 0)$erreur = "Erreur lors du transfert"; //Si ça a bien été transféré
				if ($_FILES['Image']['size'] > $maxsize) $erreur = "Le fichier est trop gros"; //Vérif de la taille
				//1. strrchr renvoie l'extension avec le point (« . »).
				//2. substr(chaine,1) ignore le premier caractère de chaine.
				//3. strtolower met l'extension en minuscules.
				$extension_upload = strtolower(  substr(  strrchr($_FILES['Image']['name'], '.')  ,1)  );
				if ( in_array($extension_upload,$extensions_valides) ) echo "Extension correcte"; //Faire un truc si ça passe pas
				
				$image_sizes = getimagesize($_FILES['Image']['tmp_name']);//Get la taille de l'image
				if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) $erreur = "Image trop grande";
				
				$nom = "photo/{$numLicence}.{$extension_upload}";
				$resultat = move_uploaded_file($_FILES['Image']['tmp_name'],$nom);
				if ($resultat) echo "Transfert réussi";
			}

		?>
	</body>
</html>
