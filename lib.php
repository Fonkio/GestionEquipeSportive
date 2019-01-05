<?php
session_start();

//Variables servant à la vérification du login/mdp
$login_valide = rechercheLogin();
$mdp_valide = rechercheMdp();

//Vérification automatique pour voir si on est log. Est présent à chaque appel de lib.php
//Si on n'est pas sur une page d'authentification, ou sur une page d'erreur d'authentification, on est redirigé vers la page d'auth
if (!(strrchr($_SERVER['SCRIPT_NAME'], '/') == "/auth.php" || strrchr($_SERVER['SCRIPT_NAME'], '/') == "/authErrLogin.php" || strrchr($_SERVER['SCRIPT_NAME'], '/') == "/authErrMdp.php")) {
    if (empty($_SESSION['login'])) {
        header('Location: auth.php');
    }
}

/*
 /!\ J'ai voulu me lancer dans la création de token pour plus de sécurité, mais le temps me manquait /!\

function creerJeton()
{
    $token_jeton = md5(time() * rand(1, 10));//Création du jeton
    $_SESSION['jtn_token'] = $token_jeton;//Stockage du jeton dans la session
    $_SESSION['jtn_token_time'] = time();//TimeStamp de la création du jeton

}

function insertJeton()
{
    $token_jeton = $_SESSION['jtn_token']; // récupération du jeton
    ?>
    <input type="hidden" name="input_token" id="input_token" value="
        <?php
    echo $token_jeton; //Le champ caché a pour valeur le jeton
    ?>"/>
    <?php
}

function verifJeton()
{

    //verif si le jeton est dans le formulaire
    if (!(isset($_SESSION['jtn_token']) && isset($_SESSION['jtn_token_time']) && isset($tab['input_token']))) {
        echo "Erreur de jeton, veuillez vous reconnecter.";
        sleep(5);
        header('Location : deconnexion.php');
        exit();
    }
    //Si le même jeton entre la session et le formulaire
    if (!($_SESSION['jtn_token'] == $tab['input_token'])) {
        echo "Le jeton n'est pas le même. Attention aux tentatives de hacking. Veuillez vous reconnecter.";
        sleep(5);
        header('Location : deconnexion.php');
        exit();
    }

    $ancien_timestamp = time() - (5 * 60);//stockage du timestamp il y a 5 minutes
    //Si le jeton est expiré
    if (!($_SESSION['jtn_token_time'] >= $ancien_timestamp)) {
        echo "Session expirée. Veuillez vous reconnecter.";
        sleep(5);
        header('Location: deconnexion.php');
        exit();
    }
}
*/

//Pour sécuriser une variable, contre les injections SQL notamment
function sécurisationVariable($var)
{
    $var = stripslashes($var); //Supprime les antislashs d'une chaîne et aussi les balises (exemple <strong>)
    $var = strip_tags($var); // Supprime les balises (code)
    $var = htmlentities($var);
    return $var;
}

//Retourne le login du site
function rechercheLogin()
{
    $linkpdo = connecterPDO();
    $reqRecherche = $linkpdo->prepare("SELECT * FROM identifiant WHERE id=:id");
    $reqRecherche->execute(array('id' => 1));
    while ($data = $reqRecherche->fetch()) {
        $Login = $data['Login'];
    }
    return $Login;
}

//Retourne le mdp hashé du site.
function rechercheMdp()
{
    $linkpdo = connecterPDO();
    $reqRecherche = $linkpdo->prepare("SELECT * FROM identifiant WHERE id=:id");
    $reqRecherche->execute(array('id' => 1));
    while ($data = $reqRecherche->fetch()) {
        $Mdp = $data['Mdp'];
    }
    return $Mdp;
}

//Renvoie la chaine cryptée
function crypterMdp($Mdp)
{
    return password_hash($Mdp, PASSWORD_DEFAULT);
}

//Compare un String en clair et un String hashé pour voir si c'est les même.
//Retourne un booléen : True si ce sont les même, false sinon.
function comparerMdp($MdpClair, $MdpCrypt)
{
    return password_verify($MdpClair, $MdpCrypt);
}

//Fonction qui sert à l'upload de l'image
function uploadImage($numLicence, $maxsize)
{
    //Upload d'image
    $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
    $maxwidth = "576"; //Largeur max
    $maxheight = "1024";//Hauteur max

    if ($_FILES['Image']['error'] > 0) $erreur = "Erreur lors du transfert"; //Si ça a bien été transféré
    if ($_FILES['Image']['size'] > $maxsize) $erreur = "Le fichier est trop gros"; //Vérif du poids

    //1. strrchr renvoie l'extension avec le point (« . »).
    //2. substr(chaine,1) ignore le premier caractère de chaine.
    //3. strtolower met l'extension en minuscules.
    $extension_upload = strtolower(substr(strrchr($_FILES['Image']['name'], '.'), 1));

    if (!(in_array($extension_upload, $extensions_valides))) { //Si l'extension n'est pas dans ce qu'on accepte
        exit("Erreur sur l'extension");
    } else {
        ajouterExtension($numLicence, $extension_upload);
    }

    $image_sizes = getimagesize($_FILES['Image']['tmp_name']);//Get la taille de l'image
    if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) $erreur = "Image trop grande";

    $nom = "photo/{$numLicence}.{$extension_upload}";//Le dossier de destination avec le nom de la photo : Le NumLicence sur joueur + "." + son extension
    $resultat = move_uploaded_file($_FILES['Image']['tmp_name'], $nom);//On move l'image
    if (!($resultat)) echo "Le transfert n'a pas pu aboutir";
}

//Ajoute l'extension de la photo dans la table joueur pour le joueur correspondant
function ajouterExtension($numLicence, $extension_upload)
{
    $linkpdo = connecterPDO();
    $reqAjout = $linkpdo->prepare("UPDATE joueur set extPhoto = :extension_upload WHERE NumLicence = :numLicence");
    $reqAjout->execute(array('numLicence' => $numLicence, 'extension_upload' => $extension_upload));
}

//Pour se connecter à la BDD
function connecterPDO()
{
    require('../config.php');//On l'a mis à l'extérieur pour ne pas avoir de problèmes lors du partage avec le git (Vu qu'on a pas les mêmes logs)
    try {
        $linkpdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $mdp);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $linkpdo;
}

//Le formulaire bootstrap que l'on utilise pour ajouter un joueur et modifier un joueur
function formulaire($nom, $tab, $titre)
{
    //BLOC Formulaire
    ?>
    <div class="container-fluid">
        <br/>
        <h2><?php echo $titre; ?> un joueur :</h2><br/>
        <!-- Titre de la page, qu'on modifie en fonction de si on est sur ajouter ou modifier-->
        <form action="<?php echo $nom; ?>" enctype="multipart/form-data" method="POST" class="needs-validation"
              novalidate> <!-- Idem sur quoi on renvoit le post-->
            <!--<?php //insertJeton();
            ?>-->
            <div class="form-row">
                <div class="col-md-8 mb-3">
                    <label for="validationCustom01">Numéro de licence</label>
                    <input type="number" name="NumLicence" class="form-control" id="validationCustom01"
                           placeholder="Numéro de licence" value="<?php if (isset($tab['NumLicence'])) {
                        echo($tab['NumLicence']);
                    } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer un numéro de licence.
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom02">Nom</label>
                    <input type="text" name="Nom" class="form-control" id="validationCustom02"
                           placeholder="Nom de famille" value="<?php if (isset($tab['Nom'])) {
                        echo($tab['Nom']);
                    } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer un nom.
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom03">Prénom</label>
                    <input type="text" name="Prenom" class="form-control" id="validationCustom03" placeholder="Prénom"
                           value="<?php if (isset($tab['Prenom'])) {
                               echo($tab['Prenom']);
                           } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer un prénom.
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom04">Date de naissance</label>
                    <input type="text" name="Ddn" class="form-control" id="validationCustom04" placeholder="JJ/MM/AAAA"
                           value="<?php if (isset($tab['Ddn'])) {
                               echo($tab['Ddn']);
                           } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer une date de naissance.
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationCustom05">Taille</label>
                    <input type="number" name="Taille" class="form-control" id="validationCustom05"
                           placeholder="(en cm)" value="<?php if (isset($tab['Taille'])) {
                        echo($tab['Taille']);
                    } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer une taille.
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationCustom06">Poids</label>
                    <input type="number" name="Poids" class="form-control" id="validationCustom06" placeholder="(en kg)"
                           value="<?php if (isset($tab['Poids'])) {
                               echo($tab['Poids']);
                           } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer un poids.
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom07">Poste favoris</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='PostePref'>
                        <option <?php if (isset($tab['PostePref'])) {
                            if ($tab['PostePref'] == 1) {
                                echo "selected";
                            }
                        } ?> value="1">Tireur
                        </option>
                        <option <?php if (isset($tab['PostePref'])) {
                            if ($tab['PostePref'] == 2) {
                                echo "selected";
                            }
                        } ?> value="2">Millieu
                        </option>
                        <option <?php if (isset($tab['PostePref'])) {
                            if ($tab['PostePref'] == 3) {
                                echo "selected";
                            }
                        } ?> value="3">Pointeur
                        </option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom07">Statut</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='Statut'>
                        <option <?php if (isset($tab['Statut'])) {
                            if ($tab['Statut'] == 1) {
                                echo "selected";
                            }
                        } ?> value="1">Actif
                        </option>
                        <option <?php if (isset($tab['Statut'])) {
                            if ($tab['Statut'] == 2) {
                                echo "selected";
                            }
                        } ?> value="2">Blessé
                        </option>
                        <option <?php if (isset($tab['Statut'])) {
                            if ($tab['Statut'] == 3) {
                                echo "selected";
                            }
                        } ?> value="3">Suspendu
                        </option>
                        <option <?php if (isset($tab['Statut'])) {
                            if ($tab['Statut'] == 4) {
                                echo "selected";
                            }
                        } ?> value="4">Absent
                        </option>
                    </select>
                </div>
            </div>

            <!-- Formulaire pour l'image. Le champ caché est pour la taille max de l'image qu'on récupère lors de l'upload image -->
            <div class="form-row">
                <label for="validationCustom08">Photo</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
                <input type="file" class="form-control-file" id="Image"
                       name="Image" <?php if (strrchr($_SERVER['SCRIPT_NAME'], '/') == "/ajouterJoueur.php") {
                    echo "required"; //Si on est sur ajouterJoueur.php, on est obligé de rentrer une photo. Donc on echo le required pour le HTML
                } ?> />
                <?php
                if (strrchr($_SERVER['SCRIPT_NAME'], '/') == "/ajouterJoueur.php") { //Idem, si on est sur ajouterJoueur.php on affiche le message d'erreur
                    ?>
                    <div class="invalid-feedback">
                        Veuillez mettre une photo.
                    </div>
                    <?php
                }
                ?>
            </div>
            <br/>
            <!-- Les boutons du formulaire -->
            <button class="btn btn-primary" type="submit" name="Ajouter"><?php echo $titre; ?></button>
            <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
        </form>


    </div>
    <script>
        //Script JS pour la vérification que tous les champs ont bien été remplis
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <?php //verifJeton();
} // Fin fonction

//Formulaire pour les matchs
//Titre = Titre de la page : Ajouter ou Modifier en l'occurence
//$tab : Tableau avec toutes les informations concernant un joueur
//Nom : Vers quelle page le formulaire va envoyer ses données
function formulaireMatch($nom, $tab, $titre)
{
    //BLOC Formulaire
    ?>
    <div class="container-fluid">
        <br/>
        <h2><?php echo $titre; ?> un match :</h2><br/>
        <form action="<?php echo $nom; ?>" method="POST" class="needs-validation" novalidate>
            <div class="form-row">
                <div class="col-md-8 mb-3">
                    <label for="validationCustom01">Date</label>
                    <input type="text" name="DateR" class="form-control" id="validationCustom01"
                           placeholder="JJ/MM/AAAA" value="<?php if (isset($tab['DateR'])) {
                        echo $tab['DateR'];
                    } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer la date du match.
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom07">Lieu</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='Lieu'>
                        <option value="Domicile" <?php if (isset($tab['Lieu'])) {
                            if ($tab['Lieu'] == 'Domicile') {
                                echo "selected";
                            }
                        } ?>>Domicile
                        </option>
                        <option value="Exterieur" <?php if (isset($tab['Lieu'])) {
                            if ($tab['Lieu'] == 'Exterieur') {
                                echo "selected";
                            }
                        } ?>>Extérieur
                        </option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom03">Adveraire</label>
                    <input type="text" name="Adversaire" class="form-control" id="validationCustom03"
                           placeholder="Nom équipe adverse" value="<?php if (isset($tab['Adversaire'])) {
                        echo $tab['Adversaire'];
                    } ?>" required>
                    <div class="invalid-feedback">
                        Veuillez rentrer le nom de l'équipe adverse.
                    </div>
                </div>
            </div>
            <h3>Joueurs et remplaçant :</h3>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationCustom07">Tireur</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='jt'>
                        <option value="-1" <?php if (isset($tab['jt'])) {
                            if ($tab['jt'] == -1) {
                                echo "selected";
                            }
                        } else {
                            echo "selected";
                        } ?>>Selectionner ...
                        </option>
                        <?php
                        $linkpdo = connecterPDO();
                        $res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur WHERE Statut = 1');
                        $res->execute(array());
                        while (($data = $res->fetch())) { ?>
                            <option value="<?php echo $data[0]; ?>" <?php if (isset($tab['jt'])) {
                                if ($tab['jt'] == $data[0]) {
                                    echo "selected";
                                }
                            } ?>><?php echo("$data[1] $data[2]"); ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom07">Millieu</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='jm'>
                        <option value="-1" <?php if (isset($tab['jm'])) {
                            if ($tab['jm'] == -1) {
                                echo "selected";
                            }
                        } else {
                            echo "selected";
                        } ?>>Selectionner ...
                        </option>
                        <?php
                        $linkpdo = connecterPDO();
                        $res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur WHERE Statut = 1');
                        $res->execute(array());
                        while (($data = $res->fetch())) { ?>
                            <option value="<?php echo $data[0]; ?>" <?php if (isset($tab['jm'])) {
                                if ($tab['jm'] == $data[0]) {
                                    echo "selected";
                                }
                            } ?>><?php echo("$data[1] $data[2]"); ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom07">Pointeur</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='jp'>
                        <option value="-1" <?php if (isset($tab['jp'])) {
                            if ($tab['jp'] == -1) {
                                echo "selected";
                            }
                        } else {
                            echo "selected";
                        } ?>>Selectionner ...
                        </option>
                        <?php
                        $linkpdo = connecterPDO();
                        $res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur WHERE Statut = 1');
                        $res->execute(array());
                        while (($data = $res->fetch())) { ?>
                            <option value="<?php echo $data[0]; ?>" <?php if (isset($tab['jp'])) {
                                if ($tab['jp'] == $data[0]) {
                                    echo "selected";
                                }
                            } ?>><?php echo("$data[1] $data[2]"); ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationCustom07">Remplaçant 1</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='r1'>
                        <option value="-1" <?php if (isset($tab['r1'])) {
                            if ($tab['r1'] == -1) {
                                echo "selected";
                            }
                        } else {
                            echo "selected";
                        } ?>>Selectionner ...
                        </option>
                        <?php
                        $linkpdo = connecterPDO();
                        $res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur WHERE Statut = 1');
                        $res->execute(array());
                        while (($data = $res->fetch())) { ?>
                            <option value="<?php echo $data[0]; ?>" <?php if (isset($tab['r1'])) {
                                if ($tab['r1'] == $data[0]) {
                                    echo "selected";
                                }
                            } ?>><?php echo("$data[1] $data[2]"); ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom07">Remplaçant 2</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='r2'>
                        <option value="-1" <?php if (isset($tab['r2'])) {
                            if ($tab['r2'] == -1) {
                                echo "selected";
                            }
                        } else {
                            echo "selected";
                        } ?>>Selectionner ...
                        </option>
                        <?php
                        $linkpdo = connecterPDO();
                        $res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur WHERE Statut = 1');
                        $res->execute(array());
                        while (($data = $res->fetch())) { ?>
                            <option value="<?php echo $data[0]; ?>" <?php if (isset($tab['r2'])) {
                                if ($tab['r2'] == $data[0]) {
                                    echo "selected";
                                }
                            } ?>><?php echo("$data[1] $data[2]"); ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom07">Remplaçant 3</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name='r3'>
                        <option value="-1" <?php if (isset($tab['r3'])) {
                            if ($tab['r3'] == -1) {
                                echo "selected";
                            }
                        } else {
                            echo "selected";
                        } ?>>Selectionner ...
                        </option>
                        <?php
                        $linkpdo = connecterPDO();
                        $res = $linkpdo->prepare('SELECT NumLicence, Nom, Prenom, Taille, Poids, PostePref FROM joueur WHERE Statut = 1');
                        $res->execute(array());
                        while (($data = $res->fetch())) { ?>
                            <option value="<?php echo $data[0]; ?>" <?php if (isset($tab['r3'])) {
                                if ($tab['r3'] == $data[0]) {
                                    echo "selected";
                                }
                            } ?>><?php echo("$data[1] $data[2]"); ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary" type="submit" name="Ajouter"><?php echo $titre ?></button>
            <a class="btn btn-light" href=javascript:history.go(-1) role="button">Retour</a>
        </form>
    </div>
    <script>
        //Script JS pour la vérification que tous les champs ont bien été remplis
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <?php
} // Fin fonction

?>
