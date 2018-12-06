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
				//BLOC Formulaire?>
				<form action="ajouterJoueur.php" method="POST" class="needs-validation" novalidate>

				  <div class="form-row">

				    <div class="col-md-8 mb-3">
				      <label for="validationCustom01">Numéro de licence</label>
				      <input type="number" name="NumLicence" class="form-control" id="validationCustom01" placeholder="Numéro de licence" value="<?php if(isset($_POST['NumLicence'])){echo($_POST['NumLicence']);} ?>" required>
				      <div class="invalid-feedback">
				        Veuillez rentrer un numéro de licence.
				      </div>
				    </div>
				    
				  </div>

				  <div class="form-row">

				  	<div class="col-md-4 mb-3">
				      <label for="validationCustom02">Nom</label>
				      <input type="text" name="Nom" class="form-control" id="validationCustom02" placeholder="Nom de famille" value="<?php if(isset($_POST['Nom'])){echo($_POST['Nom']);} ?>" required>
				      <div class="invalid-feedback">
				        Veuillez rentrer un nom.
				      </div>
				    </div>

				  	<div class="col-md-4 mb-3">
				      <label for="validationCustom03">Prénom</label>
				      <input type="text" name="Prenom" class="form-control" id="validationCustom03" placeholder="Prénom" value="<?php if(isset($_POST['Prenom'])){echo($_POST['Prenom']);} ?>" required>
				      <div class="invalid-feedback">
				        Veuillez rentrer un prénom.
				      </div>
				    </div>

				  </div>

				  <div class="form-row">
				  	
				    <div class="col-md-4 mb-3">
				      <label for="validationCustom04">Date de naissance</label>
				      <input type="text" name="Ddn" class="form-control" id="validationCustom04" placeholder="JJ/MM/AAAA" value="<?php if(isset($_POST['Ddn'])){echo($_POST['Ddn']);} ?>" required>
				      <div class="invalid-feedback">
				        Veuillez rentrer une date de naissance.
				      </div>
				    </div>

				    <div class="col-md-2 mb-3">
				      <label for="validationCustom05">Taille</label>
				      <input type="number" name="Taille" class="form-control" id="validationCustom05" placeholder="(en cm)" value="<?php if(isset($_POST['Taille'])){echo($_POST['Taille']);} ?>" required>
				      <div class="invalid-feedback">
				        Veuillez rentrer une taille.
				      </div>
				    </div>

				    <div class="col-md-2 mb-3">
				      <label for="validationCustom06">Poids</label>
				      <input type="number" name="Poids" class="form-control" id="validationCustom06" placeholder="(en kg)" value="<?php if(isset($_POST['Poids'])){echo($_POST['Poids']);} ?>" required>
				      <div class="invalid-feedback">
				        Veuillez rentrer un poids.
				      </div>
				    </div>

				  </div>

				  <div class="form-row">
				  	<div class="col-md-4 mb-3">
				  		<label for="validationCustom07">Poste favoris</label>
				  		<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='PostePref'>
							<option value="1">Tireur</option>
							<option value="2">Millieu</option>
							<option value="3">Pointeur</option>
				      </select>
				  	</div>
				  	<div class="col-md-4 mb-3">
				  		<label for="validationCustom07">Poste favoris</label>
				  		<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='Statut'>
							<option value="1">Actif</option>
							<option value="2">Blessé</option>
							<option value="3">Suspendu</option>
							<option value="4">Absent</option>
				      </select>
				  	</div>
				  </div>

				  <button class="btn btn-primary" type="submit" name="Ajouter">Ajouter</button>
				</form>

				<script>
				// Example starter JavaScript for disabling form submissions if there are invalid fields
				(function() {
				  'use strict';
				  window.addEventListener('load', function() {
				    // Fetch all the forms we want to apply custom Bootstrap validation styles to
				    var forms = document.getElementsByClassName('needs-validation');
				    // Loop over them and prevent submission
				    var validation = Array.prototype.filter.call(forms, function(form) {
				      form.addEventListener('submit', function(event) {
				        if (form.checkValidity() === false) {
				          event.preventDefault();
				          event.stopPropagation();
				        }
				        form.classList.add('was-validated');
				      }, false);
				    });
				  }, false);
				})();
				</script>
				<?php
			}



			require('header.php');
			require('lib.php');
			estLogin();
			


			if((empty($_POST['NumLicence'])||empty($_POST['Nom'])||empty($_POST['Prenom'])||empty($_POST['Ddn'])||empty($_POST['Taille'])||empty($_POST['Poids'])||empty($_POST['PostePref'])||empty($_POST['Statut']))&&isset($_POST['Ajouter'])){
				echo("Veuillez renseigner tout les champs du formulaire");
				formul();
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
