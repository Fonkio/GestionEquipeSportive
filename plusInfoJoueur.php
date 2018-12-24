<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Info Joueur</title>
</head>
<body style="color:black; background-image:url(https://amicalecoteauessert.files.wordpress.com/2017/05/petanque.jpg); background-repeat:no-repeat;">
    <?php
        require('lib.php');
        require('header.php'); ?>
        <div style="border-radius: 20px; margin-top: 100px; margin-left: 40px; margin-right: 40px;margin-bottom: 40px; background-color: rgba(255, 255, 255, .8); padding: 40px;"> <?php
        $linkpdo=connecterPDO();
        $id=sécurisationVariable($_GET['NumLicence']);

        //Préparation requête de recherche du joueur
         $reqRecherche = $linkpdo -> prepare("SELECT * FROM joueur WHERE NumLicence = :id");
         //Lancement de la requête
         $reqRecherche -> execute(array('id'=>$id));
         //On met le résultat dans des variables
          //Initialisation dans un tableau
          while($data=$reqRecherche->fetch()){
              $tab = array('NumLicence' => $data['NumLicence'],
                  'Nom' => $data['Nom'],
                  'Prenom' => $data['Prenom'],
                  'Ddn' => $data['DateDeNaissance'],
                  'Taille' => $data['Taille'],
                  'Poids' => $data['Poids'],
                  'PostePref' => $data['PostePref'],
                  'Statut' => $data['Statut']);
          }




            ?></div>
</body>
</html>
