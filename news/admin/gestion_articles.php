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
	<title>Gestion des articles</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" id="css" href="../assets/css/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
</head>
<body>
	<main>
		<section>
			<a href="index.php">Retour</a>
			<table border=1 frame=void rules=rows>
				<thead><tr><th>Titre</th><th></th><th></th></tr></thead>
				<tbody>
					<?php
						$req = $DB->query("SELECT * FROM articles ORDER BY date_publication DESC");
							while($a = $req->fetch()) {?>
								<tr><th><a href="articles_viewer.php?id=<?= $a['id']; ?>"><?php echo $a['titre']; ?></a></th><th><a href="modifier_articles.php?id=<?php echo $a['id']; ?>">MODIFIER</a></th><th><a href="supprimer_articles.php?id=<?= $a['id']; ?>">SUPPRIMER</a></th></tr>
					<?php 
						}
}?>
				</tbody>
			</table>
		</section>
	</main>
</body>
</html>