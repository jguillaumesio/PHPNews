<?php
function short_contenu($str,$page,$id,$nbr){
$normalizeChars = array(
  'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
  'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
  'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
  'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
  'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
  'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
  'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
  'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
);
$array=str_split($str);
$count=count($array);
$i=0;
$list=array();
while($i<$count-1){
  if($array[$i]=="<"){
    array_push($list,$i);
    $j=$i+1;
    while($array[$i]!=">"){
      array_push($list,$j);
      $i++;
      $j++;
    }
  }
  $i++;
}
foreach($list as $i){
  unset($array[$i]);
}
$str=implode($array);
$str=html_entity_decode($str);
$str=strtr($str, $normalizeChars);
$str=mb_substr($str, 0,$nbr);
$str="<p>".$str." <a href=".$page.".php?id=".$id.">Cliquez pour lire la suite</a></p>";
return $str;
}

$nbr_par_pages =$ini_array['nbr_par_pages'];
$nbrTotalReq = $DB->query('SELECT id FROM articles');
$articleTotaux = $nbrTotalReq->rowCount();
$pagesTotales = ceil($articleTotaux/$nbr_par_pages);
if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
   $_GET['page'] = intval($_GET['page']);
   $pageCourante =(int)$_GET['page'];
} 
else{
   $pageCourante = 1;
}
	$depart = ($pageCourante-1)*$nbr_par_pages;
	$req = $DB->query("SELECT * FROM articles ORDER BY date_publication DESC LIMIT ".$depart.",".$nbr_par_pages."");
while($articles = $req->fetch()) {
      $titre=$articles['titre'];
      $contenu=$articles['contenu'];
      $contenu=short_contenu($contenu,$ini_array['fullwidth'],$articles['id'],$ini_array['cut_articles']);
      $date_publication=$articles['date_publication'];
      $date_publication=explode(" ",$date_publication);
      $date_publication=$date_publication[0];
      $titre_preview='<a href='.$ini_array['fullwidth'].'.php?id='.$articles['id'].'>'.$articles['titre'].'</a>';
      $replace=array("{titre_preview}","{titre}","{contenu}","{date_publication}");
      $replace_with=array($titre_preview,$titre,$contenu,$date_publication);
      $fn = fopen("news/articles/template/defaut.php","r");
        while(! feof($fn))  {
          $result=htmlspecialchars(fgets($fn));
          $result=str_replace($replace,$replace_with,$result);
          $result=htmlspecialchars_decode($result);
          echo $result;
        }
      fclose($fn);
}
?>
<div style="width:100%;text-align:center;">
<?php
    for($i=1;$i<=$pagesTotales;$i++) {
        if($i == $pageCourante) {
            echo $i.' ';
        } 
        else {
            ?><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a><?php
        }
    }?>
</div>