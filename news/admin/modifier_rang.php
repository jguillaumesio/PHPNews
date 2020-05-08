<?php
session_start();
include('../connexiondb.php');
if(isset($_SESSION['rang']) AND $_SESSION['rang']<=1){echo "vous n'avez pas les droits nécessaires";header( "Refresh:2; url=../../index.php", true, 303);exit;}
elseif(empty($_SESSION['statut'])){echo "vous n'êtes pas connecté";header( "Refresh:2; url=../../index.php", true, 303);exit;}
else{
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   if(isset($_GET['rang']) AND !empty($_GET['rang'])) {
   $edit_id =(int)htmlspecialchars($_GET['id']);
   $edit_rang =htmlspecialchars($_GET['rang']);
   $rang = $DB->query('SELECT * FROM utilisateur WHERE id = ?',
   array($edit_id));
      if($rang->rowCount() == 1) {
         $rang = $rang->fetch();
         if($edit_rang=="up"){
            if($rang['rang']<=1)
            {
            $rang=$rang['rang']+1;
            $update = $DB->query('UPDATE utilisateur SET rang = ? WHERE id = ?',
            array($rang,$edit_id));
            header("location:gestion_utilisateurs.php");
            exit;
            }
            else{header("location:gestion_utilisateurs.php");exit;}
         }     
         elseif($edit_rang=="down"){
            if($rang['rang']>=1){
               $rang=$rang['rang']-1;
               $update = $DB->query('UPDATE utilisateur SET rang = ? WHERE id = ?',
               array($rang,$edit_id));
               header("location:gestion_utilisateurs.php");
               exit;
            }
            else{header("location:gestion_utilisateurs.php");exit;}
         }
         elseif($edit_rang=="ban"){
               $update = $DB->query('UPDATE utilisateur SET rang = ? WHERE id = ?',
               array(-1,$edit_id));
               header("location:gestion_utilisateurs.php");
               exit;
         }
         elseif($edit_rang=="deban"){
               $update = $DB->query('UPDATE utilisateur SET rang = ? WHERE id = ?',
               array(0,$edit_id));
               header("location:gestion_utilisateurs.php");
               exit;
         }
      }
   }
} 
   }
?>
