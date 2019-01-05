<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Info Match</title>
</head>
<body style="color:black;
                background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg);
                background-repeat:repeat;">
<?php require('header.php'); ?>
<div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;">
    <h1>Ajouter une note :</h1>
    <?php
    require('lib.php');

    if (isset($_POST['add'])) {

        $linkpdo=connecterPDO();
        if($_GET['Table'] == 'r') {
            $res = $linkpdo->prepare('UPDATE participerremplacant SET Commentaire = :n WHERE IdRencontre = :idm AND NumLicence = :idj');
        } else {
            $res = $linkpdo->prepare('UPDATE participertitulaire SET Commentaire = :n WHERE IdRencontre = :idm AND NumLicence = :idj');
        }
        $res->execute(array(
            'n' => $_POST['com'],
            'idm' => $_POST['idm'],
            'idj' => $_POST['idj']));
        print_r($_POST);
        header("Location: plusInfoMatch.php?ID=".$_POST['idm']);

    } else{?>
        <form action="" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="idm" value="<?php echo $_GET['IDm']; ?>">
            <input type="hidden" name="idj" value="<?php echo $_GET['IDj']; ?>">
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label for="validationCustom03">Nous</label>
                    <input name="com" type="text">
                </div>
                </br>
            </div>
            <button class="btn btn-primary" type="submit" name="add">Enregister le commentaire</button>
            <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
        </form>
    <?php } ?>

</body>
</html>