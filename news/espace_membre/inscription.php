<?php
$affichage=true; /* Définis la variable affichage à True */
if(!empty($_POST)){ /* Vérifie si les variables du formulaire ne sont pas vides */
    extract($_POST); /* Extrait les variables $_POST */
    $valid = true; /* Définis la variable valid à True */

        if (isset($_POST['inscription'])){
            $pseudo  = htmlentities(trim($pseudo));
            $mail = htmlentities(strtolower(trim($mail))); 
        
                $req_pseudo = $DB->query("SELECT pseudo FROM utilisateur WHERE pseudo = ?", 
                    array($pseudo)); /* Récupère les entrées correspondantes de la base de donnée */

                $req_pseudo = $req_pseudo->fetch();

                if (!empty($req_pseudo)){
                    $valid = false; /* Attribue à la variable valid la valeur false */
                    $error = "Ce pseudo existe déjà"; /* Attribue à la variable error "Ce pseudo existe déjà" */
                }
                $req_mail = $DB->query("SELECT mail FROM utilisateur WHERE mail = ?",
                    array($mail)); /* Récupère les entrées correspondantes de la base de donnée */

                $req_mail = $req_mail->fetch();

                if (!empty($req_mail)){
                    $valid = false; /* Attribue à la variable valid la valeur false */
                    $error = "Ce mail existe déjà"; /* Attribue à la variable error "Ce mail existe déjà" */
                }

                if(strlen($pseudo)>30){ /* Vérifie si le pseudo fait moins de 30 caractères */
                    $valid=false; /* Attribue à la variable valid la valeur false */
                    $error="Le pseudo doit faire moins de 30 caractères"; /* Attribue à la variable error "Le pseudo doit faire moins de 30 caractères" */
                }

                 if(strlen($pseudo)<3){ /* Vérifie si le pseudo fait plus de 2 caractères */
                    $valid=false; /* Attribue à la variable valid la valeur false */
                    $error="Le pseudo doit faire plus de 2 caractères"; /* Attribue à la variable error "Le pseudo doit faire plus de 2 caractères" */
                }

                if(preg_match('#^[a-zA-Z0-9]*$#', $pseudo)==false){
                    $valid=false;
                    $error="Le pseudo contient des caractères interdits"; /* Attribue à la variable error "Ce mail existe déjà" */
                }
        }

            if($confmdp!=$mdp){ /* Vérifie si le mot de passe est le même que la confirmation du mot de passe */
                $valid = false;
                $error = "La confirmation du mot de passe ne correspond pas"; /* Attribue à la variable error "La confirmation du mot de passe ne correspond pas" */
            }
            if($mdp == ""){ /* Vérifie si le mot de passe est vide */
                $valid = false; /* Attribue à la variable valid la valeur false */
                $error = "Le mot de passe ne peut pas être vide"; /* Attribue à la variable error "Le mot de passe ne peut pas être vide" */
            }

            if($valid){ /* Vérifie si la variable valid est à True */
                $mdp = password_hash($mdp, PASSWORD_BCRYPT, array('cost'=>8));
                $DB->insert("INSERT INTO utilisateur (pseudo, mail, mdp, rang) VALUES 
                    (?, ?, ?, ?)", 
                    array($pseudo, $mail, $mdp, 0));
                    $error="Tu es bien inscrit"; /* Attribue à la variable error "Tu es bien inscrit" */
                    $affichage=false; /* Attribue à la variable affichage la valeur false */
                    ?>
                    <script type="text/javascript">
                    setTimeout("location.href = 'index.php';",2000); // Redirige vers index.php après 2 secondes
                    </script><?php
            }
        
}
?>
<?php
    if (isset($error)){ /* Vérifie si la variable error est définie */
        echo "<p>".$error."</p><br>"; /* Affiche la variable error */
    }

if($affichage){ /* Vérifie si la variable affichage a la valeur True */
?>   
<form method="post"> <!-- Formulaire d'inscription -->
    <label>Pseudo</label><br>
    <input type="text" name="pseudo" value="<?php if(isset($pseudo)){ echo $pseudo; }?>" required><br> <!-- Zone de saisie sur une seule ligne pour le pseudo -->
    <label>Mail</label><br>
    <input type="text" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required><br> <!-- Zone de saisie sur une seule ligne pour le mail -->
    <label>Mot de passe</label><br>
    <input type="password" class="password" name="mdp" value="<?php if(isset($mdp)){ echo $mdp; }?>" required><br> <!-- Zone de saisie de type password sur une seule ligne pour le mot de passe -->
    <label>Confirmer le mot de passe</label><br>
    <input type="password" class="password" name="confmdp" required><br> <!-- Zone de saisie de type password sur une seule ligne pour la confirmation du mot de passe -->
    <input type="submit" name="inscription" value="Inscription"> <!-- Bouton d'envoi du formulaire -->
</form>
<ul>
    <li><a href="index.php">Retour</a></li> <!-- Retour à l'accueil de l'administration -->
</ul>
<?php } ?>