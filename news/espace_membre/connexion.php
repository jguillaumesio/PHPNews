<?php
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if (isset($_POST['connexion'])){
            $pseudo  = htmlentities(trim($pseudo));
            $mdp = trim($mdp);

            $req = $DB->query("SELECT * 
                FROM utilisateur 
                WHERE pseudo = ?",
                array($pseudo));
            $req = $req->fetch();
			
			if(!empty($req)){
				if(!password_verify($mdp,$req['mdp'])){
					$valid=false;
					$error="Le mot de passe ne correspond pas";
				}
				if($req['rang'] == -1){
					$valid= false;
					$error="Vous êtes banni";
				}
			}
			else{
				$valid=false;
				$error = "Le pseudo n'existe pas";
			}
            if ($valid){
                $_SESSION['id'] = $req['id'];
                $_SESSION['pseudo'] = $req['pseudo'];
                $_SESSION['mail'] = $req['mail'];
                $_SESSION['rang'] = $req['rang'];
                $_SESSION['statut'] = 1;
                ?>
                <script type="text/javascript">
                    window.location.reload()
                </script>
                <?php
                exit;
            }   
        }
    }
?>
<form method="post">
    <?php
        if (isset($error)){
            echo "".$error."<br>";
        }
    ?>
    <label>Pseudo</label><br>
    <input type="text" name="pseudo"required><br>
    <label>Mot de passe</label><br>
    <input type="password" name="mdp"required><br>
    <input type="submit" name="connexion" value="Connexion"><br>
    <a href="?inscription">Inscription</a>
</form>