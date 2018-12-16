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
    ?>
    <h3>Changer le login :</h3>
    <input type="text" name="Login" value="<?php echo"$login_valide";?>" />

    <style=float:righ;>
    <h3>Changer le mot de passe :</h3>
    <input type="password" name="Password" />
     </style>
</body>
</html>