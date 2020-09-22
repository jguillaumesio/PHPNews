<?php
	$install=false;
	function file_edit_contents($file_name, $line, $new_value){
  		$file = explode("\n", rtrim(file_get_contents($file_name)));
  		$file[$line] = $new_value;
  		$file = implode("\n", $file);
  		file_put_contents($file_name, $file);
		}
if(isset($_GET['install']) AND $_GET['install']=="finish"){
	//unlink("install.php");
	//unlink("install.sql");
	header("espace_membre/connexion.php");
}
if(!$install){
if(isset($_POST['link'],$_POST['database'],$_POST['user'])){
	if(empty($_POST['link'])){
		$error="Veuillez remplir le champ Lien";
	}
	elseif(empty($_POST['database'])) {
		$error="Veuillez remplir le champ nom de la database";
	}
	elseif(empty($_POST['user'])){
		$error="Veuillez remplir le champ nom de l'utilisateur";
	}
	else{
		$dblink=$_POST['link'];
		$dbuser=$_POST['user'];
		$dbname=$_POST['database'];
		$dbpass=$_POST['database_pass'];
		$dbconnec=true;
		try{
		$db = new PDO('mysql:host='.$dblink.';dbname='.$dbname.'',$dbuser,$dbpass);
		}
		catch(Exception $e){
			$dbconnec=false;
		}
			if($dbconnec){
				$file="connexiondb.php";
				file_edit_contents($file,3,'    private $host    ="'.$dblink.'";');
				file_edit_contents($file,4,'    private $name    ="'.$dbname.'";');
				file_edit_contents($file,5,'    private $user    ="'.$dbuser.'";');
				file_edit_contents($file,6,'    private $pass    ="'.$dbpass.'";');
				include("connexiondb.php");
				$fn = fopen("install.sql","r");
  					while(! feof($fn))  {
						$result = fgets($fn);
						$req=$DB->query($result);
  					}
 				fclose($fn);
				$error="Connexion avec la base de donnée établie avec succès !";
				file_edit_contents("index.php",1,'	$install=true;');
				header("location:install.php");
			}
			else{
				$error="Les informations saisies ne permettent pas une connexion à la base de donnée";
			}
	}
}
if(!empty($error)){ echo $error; }
?>
<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<title>INSTALLATION</title>
		<meta charset="utf-8" />
      	<link rel="stylesheet" id="css" href="assets/css/main.css" />
	</head>
	<body>
		<main>
			<section>
				<form method="POST">
					<label>Lien de phpMyAdmin :</label><br>
					<input type="text" name="link"><br>
					<label>Nom de la database :</label><br>
					<input type="text" name="database"><br>
					<label>Nom de la l'utilisateur :</label><br>
					<input type="text" name="user"><br>
					<label>Mot de passe de la database :</label><br>
					<input type="password" name="database_pass"><br>
					<input type="submit" value="Valider">
				</form>
			</section>
		</main>
	</body>
</html>
<?php }
else{
	echo "le système est déjà installé";
	header("location:../");
}?>