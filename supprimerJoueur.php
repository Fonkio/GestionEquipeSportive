<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Accueil</title>
</head>
<body>

    <?php
        require('header.php');
        require('lib.php');
        $linkpdo=connecterPDO();

        $tmp=false;

        $id=sécurisationVariable($_GET['NumLicence']);

        $reqRecherche = $linkpdo->query("SELECT Nom,Prenom FROM joueur WHERE NumLicence = $id");
        while($data=$reqRecherche->fetch()){
            $Nom = $data['Nom'];
            $Prenom = $data['Prenom'];
       }

        if(isset($_POST['Oui'])) {
                $reqSuppr=$linkpdo -> prepare ("DELETE FROM joueur WHERE NumLicence=:id");
                $reqSuppr->execute(array('id'=>$id));
                $h2="Le joueur $Nom $Prenom a bien été supprimé.";
                $tmp=true;
            }

            if(isset($_POST['Non'])){
                header('Location: joueur.php');
            }
        if($tmp==false){
            $h2="Voulez-vous vraiment supprimer le joueur : $Nom $Prenom";
        }
    ?>

    <h2 style="text-align:center;"><?php echo "$h2";?> </h2>

    <form action="" method="POST">
        <button type="submit" class="btn btn-success" name="Oui">Oui</button>
        <button type="submit" class="btn btn-danger" name="Non" >Non</button>
    </form>

</body>
</html>
