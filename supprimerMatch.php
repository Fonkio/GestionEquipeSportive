<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Supprimer un match</title>
</head>
<body>

    <?php
        require('header.php');
        require('lib.php');
        $linkpdo=connecterPDO();

        $tmp=false;

        $id=sécurisationVariable($_GET['ID']);

        if(isset($_POST['Oui'])) {
                $reqSuppr=$linkpdo -> prepare ("DELETE FROM rencontre WHERE IdRencontre=:id");
                $reqSuppr->execute(array('id'=>$id));
                $h2="Le match a bien été supprimé.";
                $tmp=true;
            }

        if($tmp==false){
            $h2="Voulez-vous vraiment supprimer le match ?";
        }
    ?>

    <h2 style="text-align:center;"><?php echo "$h2";?> </h2>
	<?php
		if($tmp==false){
	?>
   <form action="" method="POST">
      <button type="submit" class="btn btn-success" name="Oui">Oui</button>
      <a class="btn btn-danger" href="match.php" name="Non" role="button">Non</a>  
   </form>
   <?php
   		}
  	 	else
   		{
   	?>
   		<a class="btn btn-light" href="match.php" role="button">Retour</a>
   	<?php
   		}
   	?>

</body>
</html>
