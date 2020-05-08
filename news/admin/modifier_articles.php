<?php
session_start();
include('../connexiondb.php');
if(isset($_SESSION['rang']) AND $_SESSION['rang']<1){echo "vous n'avez pas les droits nécessaires";header( "Refresh:2; url=../../index.php", true, 303);exit;}
elseif(empty($_SESSION['statut'])){echo "vous n'êtes pas connecté";header( "Refresh:2; url=../../index.php", true, 303);exit;}
else{
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $edit_id =(int)htmlspecialchars($_GET['id']);
   $edit_article = $DB->query('SELECT * FROM articles WHERE id = ?',
   array($edit_id));
   if($edit_article->rowCount() == 1) {
      $edit_article = $edit_article->fetch();
   } 
   else{
      header("location:index.php");
      exit;
   }
}
else{
   header("location:index.php");
   exit;
}
if(isset($_POST['titre'], $_POST['contenu'])) {
   if(!empty($_POST['titre']) AND !empty($_POST['contenu'])) {
      $titre = htmlspecialchars($_POST['titre']);
      $contenu = $_POST['contenu'];
      $update = $DB->query('UPDATE articles SET titre = ?, contenu = ? WHERE id = ?',
      array($titre, $contenu, $edit_id));
      header( "Refresh:2; url=gestion_articles.php", true, 303);
      $message = 'Votre article a bien été mis à jour !';
   }
}
?>
<!DOCTYPE HTML>
<html>
<head>
   <title>Modifier un article</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <script src="ckeditor/ckeditor.js"></script>
   <link rel="stylesheet" id="css" href="../assets/css/main.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
</head>
<body>
   <main>
      <section>
         <form method="POST">
            <label>Titre</label><br>
            <input type="text" name="titre" placeholder="Titre" value="<?= 
            $edit_article['titre'] ?>"><br>
            <label>Contenu</label><textarea name="contenu" placeholder="Contenu de l'article" id="contenu"><?= 
            $edit_article['contenu'] ?></textarea><br>
            <input type="submit" value="Modifier l'article">
         </form>
         <p class="message"><?php if(isset($message)) { echo $message; }?></p>
         <a href="index.php">Retour</a>
      </section>
   </main>
<script>
CKEDITOR.replace('contenu');
</script>
<?php } ?>
</body>
</html>