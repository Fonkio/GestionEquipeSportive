<!DOCTYPE HTML>
<html lang="fr">
    <head>
	     <!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	    <!-- Bootstrap CSS -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>Ajouter un match</title>
    </head>
	<body>

		<?php
    		require('header.php');
			require('lib.php');
			$tab = array();

			if((empty($_POST['DateR'])||empty($_POST['Adversaire']))&&isset($_POST['Ajouter'])){
				echo("Veuillez renseigner tout les champs du formulaire correctement");
				formulaireMatch();
			}
			else{
				if(isset($_POST['Ajouter'])) {
					
					//Connexion à la BDD
					$linkpdo=connecterPDO();
				
					$DateR=sécurisationVariable($_POST['DateR']);
					$Lieu=sécurisationVariable($_POST['Lieu']);
					$Adversaire=sécurisationVariable($_POST['Adversaire']);

					$linkpdo=connecterPDO();
					
					//Préparation requête ajout
					$reqAjout = $linkpdo->prepare("INSERT INTO rencontre (
												DateRencontre,
												LieuRencontre,
												EquipeAdverse) 
												VALUES (:DateR,
												:Lieu,
												:Adversaire)");
					//Exécution requête ajout
					$tab_param = array(
					'DateR'=>$DateR,
					'Lieu'=>$Lieu,
					'Adversaire'=>$Adversaire);
					$reqAjout->execute($tab_param);
					echo("Le match contre $Adversaire a bien été ajouté<br/>");
					print_r($reqAjout->errorInfo());
					?>
					<br/>
                    <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
                    <?php
				}
				else {
					formulaireMatch();
				}
			}
		?>
	</body>
</html>
