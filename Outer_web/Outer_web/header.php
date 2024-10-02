<!DOCTYPE html>
<html lang="fr">

<head>
<?php 
include("./functions.php");

ConnectDatabase(); ?>

<meta charset="UTF-8">

<title>Outer Site</title>
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

