<!DOCTYPE HTML>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Info Match</title>
    </head>
    <body>
        <?php
            require('header.php');
        ?>
        <div class="PetiteDivCentre">
            <h1>Ajouter une note :</h1>
            <?php
            require('lib.php'); //Connexion SQL + Fonctions

            if (isset($_POST['add'])) { //Si le formulaire est validé

                $linkpdo=connecterPDO(); //Connexion bdd

                if($_GET['Table'] == 'r') { //Si le joueur est un remplaçant
                    $res = $linkpdo->prepare('UPDATE participerremplacant SET Notation = :n WHERE IdRencontre = :idm AND NumLicence = :idj');
                }
                else { //Si c'est un titulaire
                    $res = $linkpdo->prepare('UPDATE participertitulaire SET Notation = :n WHERE IdRencontre = :idm AND NumLicence = :idj');
                }

                //Exécution requête
                $res->execute(array(
                    'n' => $_POST['note'],
                    'idm' => $_POST['idm'],
                    'idj' => $_POST['idj']));

                header("Location: plusInfoMatch.php?ID=".$_POST['idm']); //Retour + info match

            }
            else { //Si formulaire pas validé ?>

                <!-- Formulaire ajout note -->
                </br>
                <form action="" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="idm" value="<?php echo $_GET['IDm']; ?>">
                    <input type="hidden" name="idj" value="<?php echo $_GET['IDj']; ?>">

                        <div class="col-md-4 mb-3" style="margin: auto">
                            <label for="validationCustom03">Note /5</label>
                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="note" required>
                                <option value="5">⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>
                            </select>
                        </div>
                        </br>
                    <button class="btn btn-primary" type="submit" name="add">Enregister la note</button>
                    <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
                </form> <?php
            } ?>
        </div>
    </body>
</html>