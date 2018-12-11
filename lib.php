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

	function formulaire($nom) {
		//BLOC Formulaire
		?>
		<div class="container-fluid">
			<br/><h2>Ajouter un joueur :</h2><br/>
			<form action="<?php echo $nom;?>" method="POST" class="needs-validation" novalidate>
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
			  			<label for="validationCustom07">Statut</label>
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
