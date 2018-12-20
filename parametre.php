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
<body style="color:black; background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg); background-repeat:no-repeat;">
    <?php
        require('header.php');
        require('lib.php'); ?><div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;"> <?php
        $linkpdo=connecterPDO();
	//On gère le login
        if(isset($_POST['Modifier_Login'])){
            //Sécurisation du login entré
            $Login=rechercheLogin();
            $tmp=sécurisationVariable($_POST['Login']);

            if($tmp==$Login){
                $string = "C'est le même login";
            }
            else{
                $reqModif = $linkpdo -> prepare("UPDATE identifiant SET Login=:tmp WHERE id=:id");
                $reqModif -> execute(array('id'=>1,'tmp'=>$tmp));
                $string = "Login changé";
            }
        }
        else {
        $string="";
        }

	//On gère le mdp
        if(isset($_POST['Modifier_Passwd'])){
            //Sécurisation du mdp entré
            $tmp=sécurisationVariable($_POST['Mdp']);
            $Mdp=rechercheMdp();
            
            if($tmp==$Mdp){
                $string = "C'est le même mot de passe";
            }
            else{
                $reqModif = $linkpdo -> prepare("UPDATE identifiant SET Mdp=:tmp WHERE id=:id");
                $reqModif -> execute(array('id'=>1,'tmp'=>$tmp));
                $string = "Mdp changé";
            }
        }

    ?>
    
    <h3>Changer le login :</h3>
    <form action="" method="POST">
        <input type="text" name="Login" />
        <button class="btn btn-primary" type="submit" name="Modifier_Login">Modifier</button>
    </form>

    <br />
    <h3>Changer le mot de passe :</h3>
    <form action="" method="POST">
        <input type="password" name="Mdp" />
        <button class="btn btn-primary" type="submit" name="Modifier_Passwd">Modifier</button>
    </form>
    
    <?php
    	echo $string;
    ?>
 </div>   
</body>
</html>
