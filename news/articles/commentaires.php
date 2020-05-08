<div id="commentaires_container">
<?php 
	$id=(int)$_GET['id'];
	$req = $DB->query("SELECT * FROM commentaires WHERE article_id=? ORDER BY date_publication DESC",
	array($id));
while($commentaires = $req->fetch()) {
	$com_contenu=$commentaires['commentaire'];
	$com_date_publication=$commentaires['date_publication'];
	$com_pseudo=$commentaires['pseudo'];
  	$replace=array("{com_contenu}","{com_pseudo}","{com_date_publication}");
  	$replace_with=array($com_contenu,$com_pseudo,$com_date_publication);
	$fn = fopen("news/articles/template/defaut_commentaires.php","r");
  	while(! feof($fn))  {
  		$result=htmlspecialchars(fgets($fn));
  		$result=str_replace($replace,$replace_with,$result);
  		$result=htmlspecialchars_decode($result);
  		echo $result;
  	}
fclose($fn);
	if(isset($_SESSION['statut']) AND $_SESSION['rang']>=1){?>
		<a href="news/admin/supprimer_commentaires.php?id=<?php echo $commentaires['id']; ?>">SUPPRIMER</a>
	<?php }
} ?>
</div>