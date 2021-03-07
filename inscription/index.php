<?php include "nav.php";
# Démarrage de la session
session_start();
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Barlow+Condensed:400,400i,700,700i" rel="stylesheet">

<link href="assets/img/ji.png" rel="icon">
<link href="assets/img/ji.png" rel="apple-touch-icon">

<style>
    /* Header */
    #header {
        background: rgba(0, 0, 0, 0.9);
    }

    /************************************************************************/
    /******************** TEXT TYPING ***************/
    /* DEMO-SPECIFIC STYLES */
    .typewriter {
        width: 90%;
    }

    .typewriter p {
        color: #28A745;
        font-family: monospace;
        overflow: hidden;
        /* Ensures the content is not revealed until the animation */
        /* border-right: .10em solid orange; The typwriter cursor */
        white-space: nowrap;
        /* Keeps the content on a single line */
        margin: 0 auto;
        /* Gives that scrolling effect as the typing happens */
        /* letter-spacing: .10em; Adjust as needed */
        animation:
            typing 3.5s steps(30, end),
            blink-caret .5s step-end infinite;
    }

    /* ********************** Pour les erreurs ********************* */
    .typewritere p {
        color: red;
        font-family: monospace;
        overflow: hidden;
        /* Ensures the content is not revealed until the animation */
        /* border-right: .10em solid orange; The typwriter cursor */
        white-space: nowrap;
        /* Keeps the content on a single line */
        margin: 0 auto;
        /* Gives that scrolling effect as the typing happens*/
        /* letter-spacing: .10em; Adjust as needed */
        animation:
            typing 3.5s steps(30, end),
            blink-caret .5s step-end infinite;
    }

    /* The typing effect */
    @keyframes typing {
        from {
            width: 0
        }

        to {
            width: 100%
        }
    }

    /* The typewriter cursor effect */
    @keyframes blink-caret {

        from,
        to {
            border-color: transparent
        }

        50% {
            border-color: grey
        }
    }
</style>
<style>
    .blockquote {
    padding: 60px 80px 40px;
    position: relative;
}
.blockquote p {
    font-family: "Utopia-italic";
    font-size: 35px;
    font-weight: 700px;
    text-align: center;
}


.blockquote:before {
  position: absolute;
  font-family: 'FontAwesome';
  top: 0;
  
  content:"\f10d";
  font-size: 200px;
  color: rgba(0,0,0,0.1);
   
}

.blockquote::after {
    content: "";
    top: 20px;
    left: 50%;
    margin-left: -100px;
    position: absolute;
    border-bottom: 3px solid #003399;
    height: 3px;
    width: 200px;
}

</style>

</head>

<body>
    <br><br><br>
    <!-- Section -->
    <div class="container">
        <section id="main" style="margin-top: -60px;">
            <div class="container mt-5 mb-5" >
                <?php

                $errors = array(); // Un tableau pour reccueillir les éventuelles erreurs
                $success = 0;      // Booleen attestant un envoi réussi du fichier
                $file = "";
                function verifyInput($data)
                {
                    $data = trim($data);
                    $data = stripcslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }



                ob_start();
                require '../config/database.php';


                // Insertion du code du téléchargement du fichier photo

                # Testons si le fichier a bien été envoyé et qu'il n'y a pas d'erreur
                if (isset($_FILES['avatar-file']) and $_FILES['avatar-file']['error'] == 0) {
                    # Testons si le fichier n'est pas trop gros (taille < 1Mo)
                    if ($_FILES['avatar-file']['size'] <= 10000000000) {
                        # Récupération de l'extention du fichier
                        $infosFichier = pathinfo($_FILES['avatar-file']['name']);

                        $extensionFichier = $infosFichier['extension'];


                        $prefix = 'ji_' . md5(time() * rand(1, 9999));
                        $newFileName = $prefix . '.' . $extensionFichier;
                        $path = '../img/profil/' . $newFileName;



                        # On compare le tableau avec un tableau d'extensions autorisés
                        $extensionAutorisees = array('jpg', 'jpeg', 'png');
                        if (in_array($extensionFichier, $extensionAutorisees)) {
                            # On valide l'upload du fichier
                            move_uploaded_file($_FILES['avatar-file']['tmp_name'], $path);
                            $success = 1;
                        } else {
                            $errors[] = "Format du fichier non supporter. Veulliez choisir un fichier au format .jpg, .png ou .jpeg.";
                        }
                    } else {
                        $errors[] = "Taille du fichier trop grande!";
                    }
                } else {
                    $errors[] = "Erreurs rencontré lors de l'envoi du fichier. Veuillez réessaiyer...";
                }

                if (isset($_POST['valider'])) {
                    # On vérifie que les champs ne sont pas vides

                    $db = Database::connect();

                    $query = $db->prepare('SELECT tel FROM etudiants WHERE tel = ?');
                    $query->execute([$_POST['tel']]);
                    $nbre = $query->fetch(PDO::FETCH_ASSOC);
                    if ($nbre) {
                        # Il y a donc un numero identique déjà présent dans la BD
                        $errors[] = "Ce numéro est déjà utilisé pour un autre compte";
                    } else {
                        $query = $db->prepare('SELECT email FROM etudiants WHERE email = ?');
                        $query->execute([$_POST['email']]);
                        $nbre = $query->fetch(PDO::FETCH_ASSOC);
                        if ($nbre) {
                            # Il y a donc un numero identique déjà présent dans la BD
                            $errors[] = "Cet adresse est déjà utilisée pour un autre compte";
                        }
                    }


                    if (empty($errors) && $success == 1) {
                        $nom = verifyInput($_POST['nom']);
                        $prenom = verifyInput($_POST['prenom']);
                        $sexe = verifyInput($_POST['sexe']);
                        $niveau = verifyInput($_POST['niveau']);
                        $tel = verifyInput($_POST['tel']);
                        $email = verifyInput($_POST['email']);
                        $photo = "img/profil/" . $newFileName;

                      
                        $date_register = date("Y-m-d");

                        if ($niveau == "LICENCE 1") {
                            $map = 15000;
                        }

                        if ($niveau == "LICENCE 3") {
                            $map = 20000;
                        }


                        $solde = 0;
                        $rap = $map - $solde;

                        // Insertion dans la table etudiant

                        //Préparation de la requête d'insertion

                        $query = $db->prepare("INSERT INTO etudiants(nom, prenom, sexe,niveau,tel, email, lien_photo, date_register) 
                                VALUE(:nom,:prenom,:sexe,:niveau,:tel,:email,:lien_photo,:date_register)");

                        // Assignation des valeurs aux différents champs

                        $query->bindValue(':nom', $nom);
                        $query->bindValue(':prenom', $prenom);
                        $query->bindValue(':sexe', $sexe);
                        $query->bindValue(':niveau', $niveau);
                        $query->bindValue(':tel', $tel);
                        $query->bindValue(':email', $email);
                        $query->bindValue(':lien_photo', $photo);
                        $query->bindValue(':date_register', $date_register);


                        // Exécution de la requête

                        $query->execute();

                        if ($query) {
                            $_SESSION['nom'] = $nom;

                            echo "  <div class='row'>
                                <div class='col-12'>
                                    <div class='alert alert-success' role='alert'>
                                        <h4 class='alert-heading'><center>Bien Joué $nom!</center></h4>
                                        <p><center>Vous venez d'être enregistré(e) avec succès.</center></p>
                                    </div>
                                    <meta http-equiv='refresh' content='3; url = ../' />
                                </div>
                            </div> ";
                        }
                    } else { ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger">
                                    <p>
                                        <center>
                                            <strong>
                                                Vous n'avez pas rempli le formulaire correctement
                                            </strong>
                                        </center>
                                    </p>
                                    <ul>
                                        <?php foreach ($errors as $error) : ?>
                                            <li class="text-center"><?= $error;  ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            </div>
                        </div>

                <?php
                    }
                }




                ?>

                <div class="text-center pt-5">
                    <a href="../">
                    <span style="border:3px solid #003399; border-radius:5%;padding-left:40px;padding-right:40px;padding-top:70px;padding-bottom:60px;">

                        <img src="images/ji.png" alt="logo ji" width="100" class="img-fluid">
                    </span>
                    </a>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 my-auto mx-auto">
                        <div class="card d-none d-lg-block">
                        <blockquote class="blockquote"><p>La seule manière de faire du bon travail, c'est d'aimer ce que vous faites.</p></blockquote>



                            <!-- <img src="images/clean-code.png" alt="" width="" class="img-fluid"> -->

                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-4">
                        <p class="text-center">Inscrivez vous pour une JI unique ☻</p>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mx-auto pl-5">

                                <div data-bs-hover-animate="pulse" class="avatar-bg center mb-3" style="height:150px;width:150px;"></div>



                            </div>
                            <div class="custom-file mb-4">

                                <input accept=".jpg,.jpeg,.gif,.png" type="file" class="custom-file-input form-control" name="avatar-file" required style="background-color:rgba(247,249,252,0);">
                                <label class="custom-file-label" for="hFichier">Sélectionner un fichier</label>

                            </div>

                            <div class="col-md-4 relative">
                                <div class="avatar"></div>
                            </div>



                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">►</span>
                                </div>
                                <input type="text" name="nom" class="form-control" required placeholder="Entrez votre nom">
                            </div>
                            <div class="input-group">
                                <input type="text" name="prenom" class="form-control" required placeholder="Entrez votre prenom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">◄</span>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">sexe</span>
                                </div>
                                <select name="sexe" id="" class="custom-select" required>
                                    <!-- <option disabled="disabled">Sexe</option> -->
                                    <option value="homme">Homme</option>
                                    <option value="femme">Femme</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <select name="niveau" id="" class="custom-select" required>
                                    <!-- <option disabled="disabled">Niveau</option> -->
                                    <option value="LICENCE 1">Licence 1</option>

                                    <option value="LICENCE 3">Licence 3</option>

                                </select>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">niveau</span>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">+225</span>
                                </div>
                                <input type="tel" name="tel" onkeyup="spacing(this.form)" class="form-control" required placeholder="0788364403" maxlength="10" />
                                <!-- <small>Exemple : 07 07 88 00 04</small> -->
                            </div>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" required placeholder="Email">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                            </div>


                            <button type="submit" name="valider" id="valider" class="col-12 mt-3 btn btn-outline-dark">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../dist/sweetalert2.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>



    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- Uncomment below i you want to use a preloader -->
    <!-- <div id="preloader"></div> -->

    <!-- JavaScript Libraries -->
    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/jquery/jquery-migrate.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/superfish/hoverIntent.js"></script>
    <script src="../lib/superfish/superfish.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/isotope/isotope.pkgd.min.js"></script>
    <script src="../lib/lightbox/js/lightbox.min.js"></script>
    <script src="../lib/touchSwipe/jquery.touchSwipe.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/all.js"></script>

    <!-- AVATAR -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script src="assets/js/Profile-Edit-Form.js"></script>

    <!-- Contact Form JavaScript File -->
    <script src="../contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="../js/main.js"></script>
    <script type="text/javascript">
        function spacing(form) {
            if (form.tel.value.length == 2 || form.tel.value.length == 5 || form.tel.value.length == 8 || form.tel.value.length == 11 {
                form.tel.value = form.tel.value + ' ';
            }

        }
    </script>

</body>

</html>