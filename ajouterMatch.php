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
			if(isset($_POST['Ajouter'])){ 
				if(($_POST['jt'] == -1)||($_POST['jm'] == -1)||($_POST['jp']== -1)||($_POST['r1'] == -1)||($_POST['r2'] == -1) || ($_POST['r3'] == -1)) {?>
					<br><h5 style="color: red">Veuillez renseigner tout les joueurs afin de constituer une équipe complète</h5>
					<?php
					formulaireMatch();
				}
				elseif(($_POST['jt'] == $_POST['jm'])||($_POST['jt'] == $_POST['jp'])||($_POST['jt'] == $_POST['r1'])||($_POST['jt'] == $_POST['r2'])||($_POST['jt'] == $_POST['r3'])||($_POST['jm'] == $_POST['jp'])||($_POST['jm'] == $_POST['r1'])||($_POST['jm'] == $_POST['r2'])||($_POST['jm'] == $_POST['r3'])||($_POST['jp'] == $_POST['r1'])||($_POST['jp'] == $_POST['r2'])||($_POST['jp'] == $_POST['r3'])||($_POST['r1'] == $_POST['r2'])||($_POST['r1'] == $_POST['r3'])||($_POST['r2'] == $_POST['r3'])) {?>
					<br><h5 style="color: red">Vous avez selectionné plusieurs fois le même joueur</h5>
					
					<?php
					formulaireMatch();
				}
				else{				
					$DateR=sécurisationVariable($_POST['DateR']);
					$Lieu=sécurisationVariable($_POST['Lieu']);
					$Adversaire=sécurisationVariable($_POST['Adversaire']);
					$jt=sécurisationVariable($_POST['jt']);
					$jm=sécurisationVariable($_POST['jm']);
					$jp=sécurisationVariable($_POST['jp']);
					$r1=sécurisationVariable($_POST['r1']);
					$r2=sécurisationVariable($_POST['r2']);
					$r3=sécurisationVariable($_POST['r3']);

					$linkpdo=connecterPDO();
					
					//Préparation requête ajout
					$reqAjout = $linkpdo->prepare("INSERT INTO rencontre (
												DateRencontre,
												LieuRencontre,
												EquipeAdverse) 
												VALUES (:DateR,
												:Lieu,
												:Adversaire)");
					//Exécution requête ajout match
					$tab_param = array(
					'DateR'=>$DateR,
					'Lieu'=>$Lieu,
					'Adversaire'=>$Adversaire);
					$reqAjout->execute($tab_param);

					//Execution requête recup id match
					$reqAjout = $linkpdo->prepare("SELECT * FROM rencontre ORDER BY 1");
					//Exécution requête ajout
					$reqAjout->execute($tab_param);

					while(($data = $reqAjout->fetch())) {
						$id = $data['IdRencontre'];
					}
					
					//Préparation requête ajout participer
					$reqAjout = $linkpdo->prepare("INSERT INTO participertitulaire (
												IdRencontre,
												NumLicence,
												Role) 
												VALUES (:IdR,
												:NumL,
												:Role)");
					//Exécution requête ajout
					$tab_param = array(
					'IdR'=>$id,
					'NumL'=>$jt,
					'Role'=>1);

					$reqAjout->execute($tab_param);
					echo $reqAjout->debugDumpParams();

					//Préparation requête ajout participer
					$reqAjout = $linkpdo->prepare("INSERT INTO participertitulaire (
												IdRencontre,
												NumLicence,
												Role) 
												VALUES (:IdR,
												:NumL,
												:Role)");
					//Exécution requête ajout
					$tab_param = array(
					'IdR'=>$id,
					'NumL'=>$jm,
					'Role'=>2);

					$reqAjout->execute($tab_param);

					//Préparation requête ajout participer
					$reqAjout = $linkpdo->prepare("INSERT INTO participertitulaire (
												IdRencontre,
												NumLicence,
												Role) 
												VALUES (:IdR,
												:NumL,
												:Role)");
					//Exécution requête ajout
					$tab_param = array(
					'IdR'=>$id,
					'NumL'=>$jp,
					'Role'=>3);

					$reqAjout->execute($tab_param);

					//Préparation requête ajout participer
					$reqAjout = $linkpdo->prepare("INSERT INTO participerremplacant (
												IdRencontre,
												NumLicence,
												Role) 
												VALUES (:IdR,
												:NumL,
												:Role)");
					//Exécution requête ajout
					$tab_param = array(
					'IdR'=>$id,
					'NumL'=>$r1,
					'Role'=>1);

					$reqAjout->execute($tab_param);

					//Préparation requête ajout participer
					$reqAjout = $linkpdo->prepare("INSERT INTO participerremplacant (
												IdRencontre,
												NumLicence,
												Role) 
												VALUES (:IdR,
												:NumL,
												:Role)");
					//Exécution requête ajout
					$tab_param = array(
					'IdR'=>$id,
					'NumL'=>$r2,
					'Role'=>2);

					$reqAjout->execute($tab_param);

					//Préparation requête ajout participer
					$reqAjout = $linkpdo->prepare("INSERT INTO participerremplacant (
												IdRencontre,
												NumLicence,
												Role) 
												VALUES (:IdR,
												:NumL,
												:Role)");
					//Exécution requête ajout
					$tab_param = array(
					'IdR'=>$id,
					'NumL'=>$r3,
					'Role'=>3);

					$reqAjout->execute($tab_param);


					echo("Le match contre $Adversaire a bien été ajouté<br/>");
					?>
					<br/>
	                <a class="btn btn-light" href="match.php">Retour</a>
	                <?php
				}
			} else {formulaireMatch();}
		?>
	</body>
</html>
