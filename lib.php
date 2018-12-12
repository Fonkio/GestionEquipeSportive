<?php
	session_start();

	if(!(strrchr($_SERVER['SCRIPT_NAME'],'/')=="/auth.php" || strrchr($_SERVER['SCRIPT_NAME'],'/')=="/authErrLogin.php" || strrchr($_SERVER['SCRIPT_NAME'],'/')=="/authErrMdp.php"))
	{
		if(empty($_SESSION['login'])){
				header('Location: auth.php');
		}
	}

	function connecterPDO(){
		require('../config.php');
		try {
			$linkpdo = new PDO("mysql:host=$host;dbname=$dbname",$login,$mdp);
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
		return $linkpdo;
	}	

	function formulaire($nom, $tab, $titre) {
		//BLOC Formulaire
		?>
		<div class="container-fluid">
			<br/><h2><?php echo $titre;?> un joueur :</h2><br/>
			<form action="<?php echo $nom;?>" method="POST" class="needs-validation" novalidate>
				<div class="form-row">
			    	<div class="col-md-8 mb-3">
			      		<label for="validationCustom01">Numéro de licence</label>
			      		<input type="number" name="NumLicence" class="form-control" id="validationCustom01" placeholder="Numéro de licence" value="<?php if(isset($tab['NumLicence'])){echo($tab['NumLicence']);} ?>" required>
			      		<div class="invalid-feedback">
			        	Veuillez rentrer un numéro de licence.
			      		</div>
			   		</div>  
			  	</div>
				<div class="form-row">
			  		<div class="col-md-4 mb-3">
			      		<label for="validationCustom02">Nom</label>
			      		<input type="text" name="Nom" class="form-control" id="validationCustom02" placeholder="Nom de famille" value="<?php if(isset($tab['Nom'])){echo($tab['Nom']);} ?>" required>
			      		<div class="invalid-feedback">
			        	Veuillez rentrer un nom.
			      		</div>
			    	</div>
			  		<div class="col-md-4 mb-3">
			      		<label for="validationCustom03">Prénom</label>
			      		<input type="text" name="Prenom" class="form-control" id="validationCustom03" placeholder="Prénom" value="<?php if(isset($tab['Prenom'])){echo($tab['Prenom']);} ?>" required>
			      		<div class="invalid-feedback">
			        	Veuillez rentrer un prénom.
			      		</div>
			    	</div>
			  	</div>
				<div class="form-row">
			    	<div class="col-md-4 mb-3">
			      		<label for="validationCustom04">Date de naissance</label>
			      		<input type="text" name="Ddn" class="form-control" id="validationCustom04" placeholder="JJ/MM/AAAA" value="<?php if(isset($tab['Ddn'])){echo($tab['Ddn']);} ?>" required>
			      		<div class="invalid-feedback">
			        	Veuillez rentrer une date de naissance.
			      		</div>
			    	</div>
			    	<div class="col-md-2 mb-3">
			      		<label for="validationCustom05">Taille</label>
			      		<input type="number" name="Taille" class="form-control" id="validationCustom05" placeholder="(en cm)" value="<?php if(isset($tab['Taille'])){echo($tab['Taille']);} ?>" required>
			      		<div class="invalid-feedback">
			        	Veuillez rentrer une taille.
			      		</div>
			    	</div>
			    	<div class="col-md-2 mb-3">
			      		<label for="validationCustom06">Poids</label>
			      		<input type="number" name="Poids" class="form-control" id="validationCustom06" placeholder="(en kg)" value="<?php if(isset($tab['Poids'])){echo($tab['Poids']);} ?>" required>
			      		<div class="invalid-feedback">
			        	Veuillez rentrer un poids.
			      		</div>
			    	</div>
			  	</div>
			  	<div class="form-row">
			  		<div class="col-md-4 mb-3">
			  			<label for="validationCustom07">Poste favoris</label>
			  			<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='PostePref'>
							<option <?php if(isset($tab['PostePref'])){if($tab['PostePref']==1){echo "selected";}} ?> value="1">Tireur</option>
							<option <?php if(isset($tab['PostePref'])){if($tab['PostePref']==2){echo "selected";}} ?> value="2">Millieu</option>
							<option <?php if(isset($tab['PostePref'])){if($tab['PostePref']==3){echo "selected";}} ?> value="3">Pointeur</option>
			      		</select>
			  		</div>
			  		<div class="col-md-4 mb-3">
			  			<label for="validationCustom07">Statut</label>
			  			<select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='Statut'>
							<option <?php if(isset($tab['Statut'])){if($tab['Statut']==1){echo "selected";}} ?> value="1">Actif</option>
							<option <?php if(isset($tab['Statut'])){if($tab['Statut']==2){echo "selected";}} ?> value="2">Blessé</option>
							<option <?php if(isset($tab['Statut'])){if($tab['Statut']==3){echo "selected";}} ?> value="3">Suspendu</option>
							<option <?php if(isset($tab['Statut'])){if($tab['Statut']==4){echo "selected";}} ?> value="4">Absent</option>
			      		</select>
			  		</div>
			  	</div>
				<button class="btn btn-primary" type="submit" name="Ajouter"><?php echo $titre;?></button>
				<a class="btn btn-light" href="index.php" role="button">Retour</a>
			</form>


		</div>
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
	} // Fin fonction 

?>
