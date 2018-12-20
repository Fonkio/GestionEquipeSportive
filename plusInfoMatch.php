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
<body>
    <?php
        require('lib.php');
        require('header.php');
        $linkpdo=connecterPDO();
        $id=sécurisationVariable($_GET['ID']);
        $reqSelect = $linkpdo->prepare("SELECT * FROM rencontre WHERE IdRencontre = :id");
        $reqSelect->execute(array('id' => $id));
        while($data=$reqSelect->fetch()){
            $Date=$data['DateRencontre'];
            $Lieu=$data['LieuRencontre'];
            $Equipe=$data['EquipeAdverse'];
        }

    ?>
    <h1><?php echo("Match contre $Equipe le $Date"); ?></h1>
</body>
</html>
