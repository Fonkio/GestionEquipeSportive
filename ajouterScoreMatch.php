<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Ajouter le score</title>
    </head>
    <body>
                    <?php require('header.php'); ?>
        <div class="PetiteDivCentre">
            <h1>Ajouter le score du match</h1> </br>
            <?php
            require('lib.php'); //Connexion SQL + fonctions

            if (isset($_POST['Modif'])) {

                    $linkpdo=connecterPDO(); //Connexion bdd
                    $res = $linkpdo->prepare('UPDATE rencontre SET ResultatEquipe = :rn, ResultatAdverse = :re WHERE IdRencontre = :id');
                    $res->execute(array(
                        'rn' => $_POST['RN'],
                        're' => $_POST['RE'],
                        'id' => $_POST['ID']));

                    header('Location: match.php');
            }
            else { ?>
                <!-- Formulaire -->
                <form action="" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="ID" value="<?php echo $_GET['ID']; ?>">
                    <div class="form-row" style="text-align: center;">
                        <div class="col-md-2 mb-3" style="margin: auto">
                            <label for="validationCustom03">Nous</label>
                            <input type="number" name="RN" class="form-control" id="validationCustom01" required>
                        </div>
                        <div class="col-md-2 mb-3" style="margin: auto">
                            <label for="validationCustom03">Eux</label>
                            <input type="number" name="RE" class="form-control" id="validationCustom02" required>
                        </div>
                    </div>
                    </br>
                    <button class="btn btn-primary" type="submit" name="Modif">Ajouter le score</button>
                    <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
                </form>
                <script>
                        (function() {
                            'use strict';
                            window.addEventListener('load', function() {
                                var forms = document.getElementsByClassName('needs-validation');
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
                </script> <?php
            } ?>
        </div>
    </body>
</html>