<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Paramètres</title>
</head>
<body>
    <?php
        require('header.php');
        require('lib.php');
        $linkpdo=connecterPDO();

        //Génération de la requête de recherche
        $reqRecherche = $linkpdo -> prepare("SELECT * FROM identifiant WHERE id=:id");
        $reqRecherche -> execute(array('id'=>1));
        while($data=$reqRecherche->fetch()){
            $Login=$data['Login'];
            $Mdp=$data['Mdp'];
        }
	
	//On gère le login
        if(isset($_POST['Modifier_Login'])){
            //Sécurisation du login entré
            $tmp=sécurisationVariable($_POST['Login']);

            if($tmp==$Login){
                echo "C'est le même login";
            }
            else{
                $Login=$tmp;
                $reqModif = $linkpdo -> prepare("UPDATE identifiant SET Login=:tmp WHERE id=:id");
                $reqModif -> execute(array('id'=>1,'tmp'=>$tmp));
                echo "Login changé";
            }
        }

	//On gère le mdp
        if(isset($_POST['Modifier_Passwd'])){
            //Sécurisation du mdp entré
            $tmp=sécurisationVariable($_POST['Mdp']);
            
            if($tmp==$Mdp){
                echo "C'est le même mot de passe";
            }
            else{
                $Mdp=$tmp;
                $reqModif = $linkpdo -> prepare("UPDATE identifiant SET Mdp=:tmp WHERE id=:id");
                $reqModif -> execute(array('id'=>1,'tmp'=>$tmp));
                echo "Mdp changé";
            }
        }
    ?>
    
    <h3>Changer le login :</h3>
    <form action="" method="POST">
        <input type="text" name="Login" value="<?php echo"$Login";?>" />
        <button class="btn btn-primary" type="submit" name="Modifier_Login">Modifier</button>
    </form>

    <br />
    <h3>Changer le mot de passe :</h3>
    <form action="" method="POST">
        <input type="password" name="Mdp" />
        <button class="btn btn-primary" type="submit" name="Modifier_Passwd">Modifier</button>
    </form>
</body>
</html>
