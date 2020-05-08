<?php 
if(isset($_GET['id']) AND !empty($_GET['id'])){
	$req = $DB->query("SELECT * FROM articles WHERE id=?",
	array($_GET['id']));
	while($articles = $req->fetch()) {
		$titre=$articles['titre'];
		$contenu=$articles['contenu'];
		$date_publication=$articles['date_publication'];
		$date_publication=explode(" ",$date_publication);
		$date_publication=$date_publication[0];
		$titre_preview='<a href='.$ini_array['fullwidth'].'.php?id='.$articles['id'].'>'.$articles['titre'].'</a>';
  		$replace=array("{titre_preview}","{titre}","{contenu}","{date_publication}");
  		$replace_with=array($titre_preview,$titre,$contenu,$date_publication);
		$fn = fopen("news/articles/template/defaut_fullwidth.php","r");
  		while(! feof($fn))  {
  			$result=htmlspecialchars(fgets($fn));
  			$result=str_replace($replace,$replace_with,$result);
  			$result=htmlspecialchars_decode($result);
  			echo $result;
  		}
  	fclose($fn);
	}
	if($ini_array['commentaires']){
		if(isset($_SESSION['statut']) AND $_SESSION['statut']==1){include("redaction_commentaires.php");}else{echo "connectez-vous pour commenter";}
		include("commentaires.php");
	}
}	
else{
	echo "Cette page n'existe pas";
}
?>