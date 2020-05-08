<?php 
session_start();
$ini_array = parse_ini_file("config.ini");
include('../connexiondb.php');
if(isset($_SESSION['rang']) AND $_SESSION['rang']<1){echo "vous n'avez pas les droits nécessaires";header( "Refresh:2; url=index.php", true, 303);exit;}
elseif(empty($_SESSION['rang'])){echo "vous n'êtes pas connecté";header( "Refresh:2; url=index.php", true, 303);exit;}
else{
	if(isset($_POST['nbr'],$_POST['com_activate'],$_POST['fullwidth']) AND !empty($_POST['fullwidth']) AND !empty($_POST['nbr']) AND !empty($_POST['com_activate'])){
		if( strval($_POST['nbr']) == strval(intval($_POST['nbr'])) ){
			function file_edit_contents($file_name, $line, $new_value){
  				$file = explode("\n", rtrim(file_get_contents($file_name)));
  				$file[$line] = $new_value;
  				$file = implode("\n", $file);
  				file_put_contents($file_name, $file);
			}	
			$file="config.ini";
			$nbr='nbr_par_pages='.$_POST['nbr'].';';
			file_edit_contents($file,0,$nbr);
			$com_activate='commentaires='.$_POST['com_activate'].';';
			file_edit_contents($file,1,$com_activate);
			$nbr_cut='cut_articles='.$_POST['nbr_cut'].';';
			file_edit_contents($file,2,$nbr_cut);
			$fullwidth='fullwidth='.$_POST['fullwidth'].';';
			file_edit_contents($file,3,$fullwidth);
			header("location:index.php");
			exit;
		}
		else{
			echo "Veuillez entrer un nombre entier";
		}
	}
}
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
	<title>Configuration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" id="css" href="../assets/css/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
</head>
<body>
	<main>
		<section>
			<form method="POST">
				<label>Nombre d'articles par page</label><br>
				<input type="text" name="nbr" value="<?php echo $ini_array['nbr_par_pages']; ?>"><br>
				<label>Nombre de caractères avant "Cliquez ici pour lire l'article"</label><br>
				<input type="text" name="nbr_cut" value="<?php echo $ini_array['cut_articles']; ?>"><br>
				<label>Activer/Désactiver les commentaires</label><br>
				<select name="com_activate">
    				<option value="true" <?php if($ini_array['commentaires']){echo "selected";} ?>>Activer</option>
    				<option value="false" <?php if(!$ini_array['commentaires']){echo "selected";} ?>>Désactiver</option>
    			</select><br>
    			<label>Nom de la page fullwidth</label><br>
    			<input type="text" value="<?php echo $ini_array['fullwidth']; ?>" name="fullwidth"><br>
				<input type="submit" value="Valider">
			</form>
			<a href="index.php">Retour</a>
		</section>
	</main>
</body>
</html>