<?php 
session_start();
include('../connexiondb.php');
if(isset($_SESSION['rang']) AND $_SESSION['rang']<=1){echo "vous n'avez pas les droits nécessaires";header( "Refresh:2; url=index.php", true, 303);exit;}
elseif(empty($_SESSION['rang'])){echo "vous n'êtes pas connecté";header( "Refresh:2; url=index.php", true, 303);exit;}
else{
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
   <title>Gestion des membres</title>
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
            <thead><tr><th>ID</th><th>Pseudo</th><th>Mail</th><th>rang</th><th>BANNIR</th></tr></thead>
            <tbody>
               <?php
                  $req = $DB->query("SELECT * FROM utilisateur ORDER BY id DESC");
                  while($a = $req->fetch()) {
                     if($a['rang']!=-1){?>
                        <tr><th><?php echo $a['id']; ?></th><th><?php echo $a['pseudo']; ?></th><th><?php echo $a['mail']; ?></th><th><a href="modifier_rang.php?id=<?php echo $a['id']; ?>&rang=down">-</a> <?php echo $a['rang']; ?> <a href="modifier_rang.php?id=<?php echo $a['id']; ?>&rang=up">+</a></th><th><a href="modifier_rang.php?id=<?php echo $a['id']; ?>&rang=ban">bannir</a></th></tr>
               <?php 
                     }
                     elseif($a['rang']==-1){?>
                        <tr><th><?php echo $a['id']; ?></th><th><?php echo $a['pseudo']; ?></th><th><?php echo $a['mail']; ?></th><th><a href="modifier_rang.php?id=<?php echo $a['id']; ?>&rang=deban">debannir</a></th></tr>   
               <?php
                     }
               }
}?>
            </tbody>
         </table>
      </section>
   </main>
</body>
</html>