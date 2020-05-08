<?php
if(isset($_POST['commentaire'],$_GET['id'])) {
	if(!empty($_POST['commentaire'] AND !empty($_GET['id']))) {
      	$commentaire = htmlspecialchars($_POST['commentaire']);
        $article_id=(int)htmlspecialchars($_GET['id']);
        $pseudo=htmlspecialchars($_SESSION['pseudo']);
        $req = $DB->query('INSERT INTO commentaires (article_id, pseudo, commentaire, date_publication) VALUES (?, ?, ?, NOW())',
        array($article_id,$pseudo,$commentaire));
	} 	
}
?>
    <div id="redaction_commentaires">
<form method="post">
	<textarea name="commentaire" placeholder="Réagissez à l'article en écrivant un commentaire !"></textarea><br>
	<input type="submit" value="Publier le commentaire">
</form>
    </div>