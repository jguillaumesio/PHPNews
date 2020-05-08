<?php
include("connexiondb.php");
if(!empty($_POST)){
    extract($_POST);
    $valid = true;

        if (isset($_POST['inscription'])){
            $pseudo  = htmlentities(trim($pseudo));
            $mail = htmlentities(strtolower(trim($mail)));

                if(strlen($pseudo)>30){
                    $valid=false;
                    $error="Le pseudo doit faire moins de 30 caractères";
                }

                 if(strlen($pseudo)<3){
                    $valid=false;
                    $error="Le pseudo doit faire plus de 2 caractères";
                }

                if(preg_match('#^[a-zA-Z0-9]*$#', $pseudo)==false){
                    $valid=false;
                    $error="Le pseudo contient des caractères interdits";
                }
        }

            if($confmdp!=$mdp){
                $valid = false;
                $error = "La confirmation du mot de passe ne correspond pas";
            }
            if($mdp == ""){
                $valid = false;
                $error = "Le mot de passe ne peut pas être vide";
            }

            if($valid){
                $mdp = password_hash($mdp, PASSWORD_BCRYPT, array('cost'=>8));
                $DB->insert("INSERT INTO utilisateur (pseudo, mail, mdp, rang) VALUES 
                    (?, ?, ?, ?)", 
                    array($pseudo, $mail, $mdp, 2));
                    header("location:index.php?install=finish");
            }
        
}
?>  
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>INSTALLATION</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" id="css" href="assets/css/main.css" />
	</head>
	<body>
		<main>
			<section>
				<form method="post">
					<label>Pseudo de l'administrateur</label><br>
					<input type="text" name="pseudo" value="<?php if(isset($pseudo)){ echo $pseudo; }?>" required><br>
					<label>Mail de l'administrateur</label><br>
					<input type="text" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required><br>
					<label>Mot de passe de l'administrateur</label><br>
					<input type="password" class="password" name="mdp" value="<?php if(isset($mdp)){ echo $mdp; }?>" required><br>
					<label>Confirmer le mot de passe de l'administrateur</label><br>
					<input type="password" class="password" name="confmdp" required><br>
					<input type="submit" name="inscription" value="Inscription">
				</form>
				<?php
					if (isset($error)){
						echo $error;
					}
				?>
			</section>
		</main>
	</body>
</html>