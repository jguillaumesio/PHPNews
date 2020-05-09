# PHPNews
Include a news system to your website easily\
You need atleast PHP v5.5.0

##INSTALLATION  
1. Create a database  
2. Put the news folder at the root of your website  
3. Now you just have to go to the link of your website and add /news (http://example.com/news) and follow instructions  
4. Create article.php page at the root of your website (it would be the fullwidth viewer for news)

At the beginning of each files where you will include something from PHPNews you need to add this:
```
<?php
session_start();
include("news/connexiondb.php");
$ini_array = parse_ini_file("news/admin/config.ini");
?>
```
To include inscription/connexion
```
<?php
	if(isset($_GET['inscription'])){
		include("news/espace_membre/inscription.php");
	}
	elseif(isset($_SESSION['statut'])){
		if($_SESSION['rang']>=1){
			echo "<a href='news/admin'>Administration</a><br>";
		}
	echo "<a href='news/espace_membre/deconnexion.php'>Déconnexion</a>";
	}
	else{
		include("news/espace_membre/connexion.php");
	}
?>
```
To include news preview 
```
<?php include("news/articles/articles.php"); ?>
```
To include full news
```
<?php include("news/articles/articles_viewer.php"); ?>
```

##MODIFICATION
The default articles theme is in news/articles/template/defaut.php
The default fullwidth articles theme is in news/articles/template/defaut_fullwidth.php
Fullwidth articles theme modification functions are the same as articles ones.
Articles theme modification
Articles functions :
```
{titre_preview} to display the title link to fullwidth article
{titre} to display the title of the article
{contenu} to display the contenu of the article
{date_publication} to display the publication date of the article
```

The default comments theme is in news/articles/template/defaut_commentaires.php
Comments theme modification
Comments functions :
```
{com_pseudo} to display the title link to fullwidth article
{com_contenu} to display the title of the article
{com_date_publication} to display the publication date of the article
```
