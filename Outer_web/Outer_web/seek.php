


<!DOCTYPE html>
<html lang="fr">

<head>
<?php 
/*J'ai du créer cette page pour assembler recherche.php et recherche_ajax.php
Si j'inclus le header dans un des deux fichiers, alors soit certains objets du code ne sont plus reconnus, soit la barre
de recherche apparait sur une page blanche puis avant le header lorsqu'on tape quelque chose.
Cette page est la solution que j'ai trouvé à ce problème et permet de rendre la page plus lisible*/ 
include("./functions.php");

ConnectDatabase(); ?>

<meta charset="UTF-8">

<link rel="icon"  href="./Style/Images/outer.png">
<link rel="stylesheet" href="./Style/sitecss.css">

<div id="MainContainer">

<?php if(isset($_COOKIE["name"]) && isset($_COOKIE["mdp"])) 
{
    echo
    '<nav>
        <a href="Index.php"><img class=logo src="./Style/Images/logo.png"></a>
	        <ul class="menu">
        <li>
            <a href="Index.php" >Accueil</a>
        </li>
    
        <li> 
            <a href="Posts.php?userID='.$_COOKIE["id"].'">Mon profil</a>
        </li>
        <li>
            <a href="./seek.php" > Recherche </a >
        </li>

	</ul>

	</nav>
    <br>';
}

else 
{
	echo
    '<nav>
    <a href="Index.php"><img class=logo src="./Style/Images/logo.png"></a>

	<ul class="menu">

        <li>
            <a href="Index.php" >Accueil</a>
        </li>
        <li> 
            <a href="Posts.php">Mon profil</a>
        </li>
	    <li>
            <a href="inscription.php">Inscription</a>
        </li>
	</ul>
	</nav>
    <br>';

}?>

</head>
<body>
    <h1>Rechercher un post</h1>
    <p>Dans cet espace vous pouvez rechercher un post en fonction de son contenu (pas de son intitulé car je pense 
        aux # plus qu'a une recherche de titre).La recherche est instantanée grace à AJAX</p>
 
</body>
<?php include("./recherche_ajax.php"); ?>

