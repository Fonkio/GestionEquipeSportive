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
        <title>Accueil</title>
    </head>
    <body>
        <div class="DivPage">
            <h1 style="text-align:center;">Statistiques</h1>
            <?php
                require('header.php');
                require('lib.php');
                $linkpdo = connecterPDO();

                //Requête pour le nombre total de matchs joués
                $reqRechercheTotal = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null");
                $reqRechercheTotal -> execute();
                while ($data = $reqRechercheTotal -> fetch()) {
                    $nbMatchTotal=$data['count(*)'];
                }

                //Requête pour le nombre de victoire
                $reqRechercheWin = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null AND ResultatEquipe > ResultatAdverse");
                $reqRechercheWin -> execute();
                while ($data = $reqRechercheWin -> fetch()) {
                    $nbMatchWin=$data['count(*)'];
                }

                //Requête pour le nombre de nuls
                $reqRechercheNul = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null AND ResultatEquipe = ResultatAdverse");
                $reqRechercheNul -> execute();
                while ($data = $reqRechercheNul -> fetch()) {
                    $nbMatchNul=$data['count(*)'];
                }

                //Requête pour le nombre de lose
                $reqRechercheLose = $linkpdo -> prepare("SELECT count(*) FROM rencontre WHERE ResultatEquipe is not null AND ResultatAdverse is not null AND ResultatEquipe < ResultatAdverse");
                $reqRechercheLose -> execute();
                while ($data = $reqRechercheLose -> fetch()) {
                    $nbMatchLose=$data['count(*)'];
                }

                //Calcul des pourcentages :
                if($nbMatchTotal == 0)//On fait attention à la division par 0
                {
                    $prctWin = 0;
                    $prctLose = 0;
                    $prctNul = 0;
                }
                else {
                    $prctWin = substr(($nbMatchWin / $nbMatchTotal) * 100,0,5);
                    $prctNul =  substr(($nbMatchNul / $nbMatchTotal) * 100,0,5);
                    $prctLose =  substr(($nbMatchLose / $nbMatchTotal) * 100,0,5);
                }
            //Je ferme la balise pour afficher les stats
             ?>
            <h4>Nombre match : <?php echo $nbMatchTotal;?> </h4>
            <h4>Nombre de victoires : <?php echo $nbMatchWin." (".$prctWin."%)"; ?> </h4>
            <h4>Nombre de nuls : <?php echo $nbMatchNul." (".$prctNul."%)"; ?> </h4>
            <h4>Nombre de perdus : <?php echo $nbMatchLose." (".$prctLose."%)"; ?> </h4>
            <br/>
            <h1 style="text-align:center;">Tableau des joueurs</h1>
            <br/>
            <?php
                //Requête pour avoir tous les numéros de licence
                $reqNumLicence = $linkpdo->prepare("SELECT NumLicence FROM joueur");
                $reqNumLicence -> execute();
                //Tableau bootstrap
            ?>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Numéro de licence</th>
                        <th scope="col">Statut actuel</th>
                        <th scope="col">Poste préféré</th>
                        <th scope="col">Nombre total de sélection en tant que titulaire</th>
                        <th scope="col">Nombre total de sélection en tant que remplaçant</th>
                        <th scope="col">Moyenne des évaluations</th>
                        <th scope="col">Matchs gagnés</th>
                    </tr>
                </thead>
                <?php
                    while ($data = $reqNumLicence -> fetch()) {//Boucle pour chaque joueur
                        $numLicence = $data['NumLicence'];

                        //Requête pour avoir le statut actuel et le poste préféré
                        $reqRechercheJoueur = $linkpdo->prepare("SELECT PostePref, Statut FROM joueur WHERE NumLicence = :numLicence");
                        $reqRechercheJoueur->execute(array('numLicence' => $numLicence));
                        while ($data = $reqRechercheJoueur->fetch()) {
                            switch ($data['PostePref']) {
                                case 1 :
                                    $postePref = "Tireur";
                                    break;
                                case 2 :
                                    $postePref = "Milieu";
                                    break;
                                case 3 :
                                    $postePref = "Pointeur";
                                    break;
                            }
                            switch ($data['Statut']) {
                                case 1 :
                                    $statut = "Actif";
                                    break;
                                case 2 :
                                    $statut = "Bléssé";
                                    break;
                                case 3 :
                                    $statut = "Suspendu";
                                    break;
                                case 4 :
                                    $statut = "Absent";
                                    break;
                            }
                        }
                        //Requête pour avoir le nombre total de sélection en tant que titulaire
                        $reqTitulaire = $linkpdo->prepare("SELECT count(*) FROM participertitulaire WHERE NumLicence = :numLicence");
                        $reqTitulaire->execute(array('numLicence' => $numLicence));
                        while ($data = $reqTitulaire->fetch()) {
                            $nbTitulaire = $data['count(*)'];
                        }

                        //Requête pour avoir le nombre total de sélection en tant que remplaçant
                        $reqRemplacant = $linkpdo->prepare("SELECT count(*) FROM participerremplacant WHERE NumLicence = :numLicence");
                        $reqRemplacant->execute(array('numLicence' => $numLicence));
                        while ($data = $reqRemplacant->fetch()) {
                            $nbRemplacant = $data['count(*)'];
                        }

                        //Requête pour avoir la moyenne des évaluations
                        $reqEval1 = $linkpdo->prepare("SELECT avg(Notation) FROM participertitulaire WHERE NumLicence = :numLicence");
                        $reqEval2 = $linkpdo->prepare("SELECT avg(Notation) FROM participerremplacant WHERE NumLicence = :numLicence");
                        $reqEval1->execute(array('numLicence' => $numLicence));
                        $reqEval2->execute(array('numLicence' => $numLicence));
                        while ($data = $reqEval1->fetch()) {
                            $moyenne1 = $data['avg(Notation)'];
                        }
                        while ($data = $reqEval2->fetch()) {
                            $moyenne2 = $data['avg(Notation)'];
                        }

                        if($moyenne1 == 0 && $moyenne2 == 0)//On fait attention à la division par
                        {
                            $moyenne = 0;
                        }
                        elseif($moyenne1 == 0 ) {
				$moyenne = $moyenne2;
                        }
                        elseif($moyenne2 == 0) {
                             $moyenne=$moyenne1;
                        }
                        else{
				$moyenne = ($moyenne1 + $moyenne2) / 2;
                        }
                     

                        //Requête pour le nombre total de matchs joués
                        //En tant que titulaire
                        $reqRechercheTotalTitulaire = $linkpdo->prepare("SELECT count(*) FROM rencontre r, participertitulaire pt WHERE r.IdRencontre = pt.IdRencontre AND pt.NumLicence = :numLicence ");
                        $reqRechercheTotalTitulaire->execute(array("numLicence" => $numLicence));
                        while ($data = $reqRechercheTotalTitulaire->fetch()) {
                            $nbMatchTotalTitulaire = $data['count(*)'];
                        }

                        //En tant que remplacant
                        $reqRechercheTotalRemplacant = $linkpdo->prepare("SELECT count(*) FROM rencontre r, participerremplacant pr WHERE r.IdRencontre = pr.IdRencontre AND pr.NumLicence = :numLicence ");
                        $reqRechercheTotalRemplacant->execute(array("numLicence" => $numLicence));
                        while ($data = $reqRechercheTotalRemplacant->fetch()) {
                            $nbMatchTotalRemplacant = $data['count(*)'];
                        }
                        $nbMatchTotal = $nbMatchTotalRemplacant + $nbMatchTotalTitulaire;

                        //Requête pour avoir le nombre de victoire
                        //En tant que titulaire
                        $reqRechercheWinTitulaire = $linkpdo->prepare("SELECT count(*) FROM rencontre r, participertitulaire pt WHERE r.IdRencontre = pt.IdRencontre AND pt.NumLicence = :numLicence AND r.ResultatEquipe > r.ResultatAdverse");
                        $reqRechercheWinTitulaire->execute(array("numLicence" => $numLicence));
                        while ($data = $reqRechercheWinTitulaire->fetch()) {
                            $nbMatchWinTitulaire = $data['count(*)'];
                        }

                        //En tant que replacant
                        $reqRechercheWinRemplacant = $linkpdo->prepare("SELECT count(*) FROM rencontre r, participerremplacant pr WHERE r.IdRencontre = pr.IdRencontre AND pr.NumLicence = :numLicence AND r.ResultatEquipe > r.ResultatAdverse ");
                        $reqRechercheWinRemplacant->execute(array("numLicence" => $numLicence));
                        while ($data = $reqRechercheWinRemplacant->fetch()) {
                            $nbMatchWinRemplacant = $data['count(*)'];
                        }
                        $nbMatchWinTotal = $nbMatchWinRemplacant + $nbMatchWinTitulaire;
                        if($nbMatchTotal == 0)
                        {
                            $prctWin = 0;
                        }
                        else {
                            $prctWin = substr(($nbMatchWinTotal / $nbMatchTotal) * 100,0,5);
                        } ?>
                        <tr>
                            <td><?php echo $numLicence; ?></td>
                            <td><?php echo $statut; ?></td>
                            <td><?php echo $postePref; ?></td>
                            <td><?php echo $nbTitulaire; ?></td>
                            <td><?php echo $nbRemplacant; ?></td>
                            <td><?php echo $moyenne; ?></td>
                            <td><?php echo $nbMatchWinTotal." (".$prctWin."%)"; ?></td>
                        </tr><?php
                    } //Fin while
                ?>
            </table>
        </div>
    </body>
</html>

