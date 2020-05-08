<?php
session_start(); /* Charge le fichier contenant les variables de session */
include('../connexiondb.php'); /* Charge le fichier de connexion à la base de donnée */
if(isset($_SESSION['rang']) AND $_SESSION['rang']<1){echo "vous n'avez pas les droits nécessaires";header( "Refresh:2; url=../../index.php", true, 303);exit;} /* Si le rang de l'utilisateur est inférieur à 1 il est redirigé vers le site */
elseif(empty($_SESSION['rang'])){echo "vous n'êtes pas connecté";header( "Refresh:2; url=../../index.php", true, 303);exit;} /* Si l'utilisateur n'est pas connecté il est redirigé vers le site */
else{
$message="";
if(isset($_POST['titre'], $_POST['contenu'])) { /* Vérifie si les variables sont définies */
	if(!empty($_POST['titre']) AND !empty($_POST['contenu'])) { /* Vérifie si les variables ne sont pas vides */
		$titre = htmlspecialchars($_POST['titre']);
        $contenu=$_POST['contenu'];
        $req = $DB->query('INSERT INTO articles (titre, contenu, date_publication) VALUES (?, ?, NOW())',
        array($titre,$contenu)); /* Insère l'article dans la base de donnée */
        $message = 'Votre article a bien été posté'; /* Attribue à la variable message la phrase "Votre article a bien été posté" */
        header( "Refresh:2; url=index.php", true, 303); /* Redirige vers l'accueil de l'administration avec un délai de 2 secondes */
	} 
    else{$message='Veuillez remplir tous les champs';} /* Attribue à la variable message la phrase "Veuillez remplir tous les champs" */
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Rédiger un article</title> <!-- Titre de la page -->
    <meta charset="utf-8"> <!-- Encodage de la police d'écriture en UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Permet la responsivité sur les appareils mobiles -->
    <script src="ckeditor/ckeditor.js"></script> <!-- Chargement du script CKEDITOR -->
    <link rel="stylesheet" id="css" href="../assets/css/main.css"> <!-- Chargement du CSS principal -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins"> <!-- Chargement d'une police d'écriture grâce à l'API Google -->
</head>
<body>
    <main>
        <section>
            <form method="post"> <!-- Formulaire pour la rédaction de l'article -->
	            <label>Titre</label><br>
                <input type="text" name="titre"><br> <!-- Zone de saisie sur une seule ligne pour le titre de l'article -->
	            <label>Contenu</label><br>
                <textarea name="contenu" id="contenu"></textarea> <!-- Zone de saisie sur plusieurs lignes pour le contenu de l'article -->
	            <input type="submit" value="Publier l'article"> <!-- Bouton d'envoi du formulaire -->
            </form>
            <p class="message"><?php if(isset($message)) { echo $message; } ?></p> <!-- Affiche les différents messages d'erreurs ou de succès -->
            <a href="index.php">Retour</a> <!-- Retour à l'accueil de l'administration -->
        </section>
    </main>
<script>
CKEDITOR.replace("contenu"); // Remplace le textarea "contenu" par le textarea de CKEDITOR
CKEDITOR.config.contentsCss = 'ckeditor/contents.css'; // Charge le CSS du module CKEDITOR
</script>
<?php } ?>
</body>
</html>