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
            $rn=$data['ResultatEquipe'];
            $re=$data['ResultatAdverse'];

        }?>
<div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;">
        <br>
        <h3><?php echo("Info du match :"); ?></h3><br><?php
        echo ("Adversaire : $Equipe </br>");
        echo ("Date : $Date </br>");
        echo ("Score : ");

        if(is_null($rn)&&is_null($re)){?>
            <a href="ajouterScoreMatch.php?ID=<?php echo $_GET['ID'] ?>"><button class="btn btn-primary" >Ajouter un score</button></a><?php
        } else {
            echo ("(Nous - Eux) <br>".$rn." - ".$re);
        }

        $reqSelect = $linkpdo->prepare("SELECT * FROM participertitulaire WHERE IdRencontre = :id ORDER BY Role");
        $reqSelect->execute(array('id' => $id));
        ?>
        <h3>Joueurs titulaires :</h3><br>
        <table class="table">
        <thead class="thead-dark">
            <tr>
                <!--<td>Photo</td>-->
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Rôle</th>
                <th scope="col">Notation</th>
                <th scope="col">Commentaire</th>
            </tr>
        </thead>
        <?php
        while($data=$reqSelect->fetch()){
            $reqSelectJ = $linkpdo->prepare("SELECT * FROM joueur WHERE NumLicence = :nl");
            $reqSelectJ->execute(array('nl' => $data['NumLicence']));
            while($dataJ=$reqSelectJ->fetch()){
                $nomJ = $dataJ['Nom'];
                $prenomJ = $dataJ['Prenom'];
            }?>
            <tr>
                <td><?php echo $nomJ ?></td>
                <td><?php echo $prenomJ ?></td>
                <td><?php if($data['Role'] == 1){ echo("Tireur");}elseif ($data['Role']==2) {echo "Millieu";}else{echo "Pointeur";} ?></td>
                <td><?php
                    if(is_null($data['Notation'])){
                        ?>
                        <a href="ajouterNote.php?IDm=<?php echo $_GET['ID'];echo '&IDj='; echo $data['NumLicence']; echo '&Table=t' ?>"><button class="btn btn-primary" >Ajouter note</button></a>
                        <?php
                    } else
                        echo($data['Notation']);
                    ?>
                </td>
                <td><?php
                    if(is_null($data['Commentaire'])){
                        ?>
                        <a href="ajouterComm.php?IDm=<?php echo $_GET['ID'];echo '&IDj='; echo $data['NumLicence']; echo '&Table=t'  ?>"><button class="btn btn-primary" >Ajouter commentaire</button></a>
                        <?php
                    } else
                        echo($data['Commentaire']);
                    ?>
                    </td>
            </tr><?php
        }?>
        </table>




        <?php 

         $reqSelect = $linkpdo->prepare("SELECT * FROM participerremplacant WHERE IdRencontre = :id ORDER BY Role");
        $reqSelect->execute(array('id' => $id));
        ?>
        <h3>Joueurs remplaçants :</h3><br>
        <table class="table">
        <thead class="thead-dark">
            <tr>
                <!--<td>Photo</td>-->
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Rôle</th>
                <th scope="col">Notation</th>
                <th scope="col">Commentaire</th>
            </tr>
        </thead>
        <?php
        while($data=$reqSelect->fetch()){
            $reqSelectJ = $linkpdo->prepare("SELECT * FROM joueur WHERE NumLicence = :nl ");
            $reqSelectJ->execute(array('nl' => $data['NumLicence']));
            while($dataJ=$reqSelectJ->fetch()){
                $nomJ = $dataJ['Nom'];
                $prenomJ = $dataJ['Prenom'];
            }?>
            <tr>
                <td><?php echo $nomJ ?></td>
                <td><?php echo $prenomJ ?></td>
                <td><?php if($data['Role'] == 1){ echo("Tireur");}elseif ($data['Role']==2) {echo "Millieu";}else{echo "Pointeur";} ?></td>
            <td><?php
                if(is_null($data['Notation'])){
                    ?>
                    <a href="ajouterNote.php?IDm=<?php echo $_GET['ID'];echo '&IDj='; echo $data['NumLicence']; echo '&Table=r' ?>"><button class="btn btn-primary" >Ajouter note</button></a>
                    <?php
                } else
                    echo($data['Notation']);
                    ?>
            </td>
            <td><?php
                if(is_null($data['Commentaire'])){
                    ?>
                    <a href="ajouterComm.php?IDm=<?php echo $_GET['ID'];echo '&IDj='; echo $data['NumLicence']; echo '&Table=r'  ?>"><button class="btn btn-primary" >Ajouter commentaire</button></a>
                    <?php
                } else
                    echo($data['Commentaire']);
                    ?>
            </td>
            </tr><?php
        }
        ?>
    </table>
    <div style="margin-left :40%; margin-right : 40%;">

      <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
    </div>
</div>
</body>
</html>
