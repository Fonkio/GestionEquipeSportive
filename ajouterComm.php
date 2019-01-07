<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Commentaire</title>
    </head>
    <body>
        <?php
            require('header.php'); //Affichage de l'entête
        ?>
        <div class="PetiteDivCentre">
            <h1>Ajouter un commentaire :</h1>
            <?php
                require('lib.php'); //Connexion sql + fonctions

            if (isset($_POST['add'])) { //Si le formulaire a été validé

                $linkpdo=connecterPDO();//Connexion bdd

                if($_GET['Table'] == 'r') {//Si c'est un remplaçant

                    $res = $linkpdo->prepare('UPDATE participerremplacant SET Commentaire = :n WHERE IdRencontre = :idm AND NumLicence = :idj');

                } else {//Sinon (c'est un titulaire)

                    $res = $linkpdo->prepare('UPDATE participertitulaire SET Commentaire = :n WHERE IdRencontre = :idm AND NumLicence = :idj');

                }

                $res->execute(array(
                    'n' => $_POST['com'], //Le commentaire
                    'idm' => $_POST['idm'], //ID match
                    'idj' => $_POST['idj'])); //Num licence

                header("Location: plusInfoMatch.php?ID=".$_POST['idm']);//Retour sur la page + info

            } else{
                ?>
                <!--Formulaire ajouter un commentaire-->
                <form action="" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="idm" value="<?php echo $_GET['IDm']; ?>">
                    <input type="hidden" name="idj" value="<?php echo $_GET['IDj']; ?>">
                    <div class="form-row">

                            <textarea name="com" class="form-control" id="exampleFormControlTextarea1" placeholder="Entrez votre commentaire" rows="3"></textarea>


                    </div>
                    </br>
                    <button class="btn btn-primary" type="submit" name="add">Enregister le commentaire</button>
                    <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
                </form> <?php
            } ?>
        </div>
    </body>
</html>