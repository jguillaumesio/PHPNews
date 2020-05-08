<?php
session_start();
include('../connexiondb.php');
if(isset($_SESSION['rang']) AND $_SESSION['rang']<1){echo "vous n'avez pas les droits nécessaires";header( "Refresh:2; url=../../index.php", true, 303);exit;}
elseif(empty($_SESSION['rang'])){echo "vous n'êtes pas connecté";header( "Refresh:2; url=../../index.php", true, 303);exit;}
else{
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $suppr_id =(int)htmlspecialchars($_GET['id']);
   $suppr = $DB->query('DELETE FROM articles WHERE id = ?',
   array($suppr_id));
   header("Location:gestion_articles.php");
   exit;
}
else{
	header("location:index.php");
    exit;
}
}
?>