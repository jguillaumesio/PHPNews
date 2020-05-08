<?php
session_start();
include('../connexiondb.php');
if(isset($_SESSION['rang']) AND $_SESSION['rang']<1){echo "vous n'avez pas les droits nécessaires";header( "Refresh:2; url=../../index.php", true, 303);exit;}
elseif(empty($_SESSION['rang'])){echo "vous n'êtes pas connecté";header( "Refresh:2; url=../../index.php", true, 303);exit;}
else{
?>
<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<title>Administration</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
      	<link rel="stylesheet" id="css" href="../assets/css/main.css">
      	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
	</head>
	<body>
	<main>
		<nav>
			<table>
				<tr><th><li><a href="redaction.php">Rédiger un article</a></li></th></tr>
			<tr><th><li><a href="gestion_articles.php">Gestionnaire d'articles</a></li></th></tr>
			<?php if($_SESSION['rang']==2){?><tr><th><li><a href="gestion_utilisateurs.php">Gestionnaire d'utilisateurs</a></li></th></tr>
			<tr><th><li><a href="configurate.php">Configuration</a></li></th></tr>
			<?php } ?>
			<tr><th><li><a href="../espace_membre/deconnexion.php">Déconnexion</a></li></th></tr>
			<tr><th><li><a href="../../">Retour sur le site</a></li></th></tr>
			</table>
		</nav>
	</main>
	</body>
</html>
<?php } ?>