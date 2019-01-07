<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Joueurs</title>
    </head>
    <body>
        <?php
        require('header.php');
        ?>
        <div class="DivPage">
            </br>
            <h2 style="text-align:center">Joueurs présents</h2></br>
            <!-- Tableau bootstrap -->
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Numéro de licence</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Taille</th>
                    <th scope="col">Poids</th>
                    <th scope="col">Poste préféré</th>
                    <th scope="col"></th><!-- Truc pour modifier-->
                    <th scope="col"></th><!-- Truc pour plus d'info-->
                    <th scope="col"></th><!-- Truc pour supprimer-->

                </tr>
                </thead>
                <?php
                require('lib.php');
                $linkpdo = connecterPDO(); ?>
                <form method=POST action="">
                    <?php
                    //Préparation de la requête
                    $res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur');
                    $res->execute(array());
                    while (($data = $res->fetch())) {//Boucle pour chaque joueur
                    ?>
                    <tr>
                        <td><?php echo "$data[0]" ?></td>
                        <td><?php echo "$data[1]" ?></td>
                        <td><?php echo "$data[2]" ?></td>
                        <td><?php echo "$data[3]" ?></td>
                        <td><?php echo "$data[4]" ?></td>
                        <td><?php switch ($data[5]) {
                                case 1:
                                    echo "Tireur";
                                    break;
                                case 2:
                                    echo "Milieu";
                                    break;
                                case 3:
                                    echo "Pointeur";
                                    break;
                            } ?></td>
                        <!-- Les liens pour intéragir-->
                        <td><a href=<?php echo "supprimerJoueur.php?NumLicence=$data[0]"; ?>>Supprimer</a></td>
                        <td><a href=<?php echo "modifierJoueur.php?NumLicence=$data[0]"; ?>>Modifier</a></td>
                        <td><a href=<?php echo "plusInfoJoueur.php?NumLicence=$data[0]"; ?>>Plus d'info</a></td>
                    </tr>
                </form>
            <?php }

            //On ferme le curseur
            $res->closeCursor();
            ?>

            </table>
            <a style="background-color: #818181;" class="btn btn-secondary btn-lg btn-block" href="ajouterJoueur.php" role="button">Ajouter joueur</a>
        </div>
    </body>
</html>
