<?php
include("header.php"); //<div class= "sticky" href="login.php">le texte sticky oui</div>
//<p>Déjà un compte? Cliquez <a class = "sticky" href="login.php">Ici</a> <p href="https://fr.wikipedia.org/">

session_start();
?>
<body>
<h1> Bienvenue dans l'Outer Web</h1>
<h2>Recherche de quelque chose en particulier?</h2>
<h3>Rendez-vous dans l'onglet "Recherche"!! Seuls les membres possèdent cet outil </h3>

<h2>Nos aventuriers du net:</h2>
<?php include("displayUsers.php"); 

//on veut pouvoir rechercher des mots clefs?>
<?php if(isset($_COOKIE["name"]) && isset($_COOKIE["mdp"])) 
{
    echo'<div class=profil_page><a href="logout.php"><img class=sticky src="./Style/Images/logout.png"></a></div><br><br>';
}else{
    echo'<div class=profil_page><a href="login.php"><img class=sticky src="./Style/Images/login.png" alt=login></a></div>';
}?>


<br><br>

<?php
function DisplayAllPosts(){
    global $db;
    
    checkLogin();
    $query = "SELECT * FROM `post` ORDER BY date_post DESC";//DESC LIMIT 10";
    $result = $db->query($query);

        $count=0;
        while($row = $result->fetch_assoc())
        {
            echo '<div class="blogPost"> ';//<div class="postTitle">
            $timestamp =$row["date_post"];

            $bigQuery ="SELECT post.id,post.id_user,utilisateurs.pp,utilisateurs.id,utilisateurs.surnom,post.date_post FROM post INNER JOIN utilisateurs 
                ON post.id_user = utilisateurs.id ORDER BY date_post DESC LIMIT $count,1";
            $bigResult = $db->query($bigQuery);
            $oui=$bigResult->fetch_assoc();
            $count +=1;

            $ownerName=$oui["surnom"];
            $profile_pic=$oui["pp"];
            echo '
            <div class="postAuthor">Posté par '.$ownerName.'</div>
            ';
        
         
    //truc pour mettre la last modif
        $image = $row["img"];

            echo '<div class=postStyle>
                  <p style="float:right"><img src="'.$profile_pic.'" class="smolrond"> </p>
                  <p class="postTitle">'.$row["nom_post"].'</p>
                  <p class="modif_time">dernière modification le '.$timestamp.'</p>
                  <p class="postContent">'.$row["description"].'</p>
                  <img class="post_pic" src="'.$image.'" alt="texte alternatif" />                  
                  </div>
                <br>
                </div>';
        }    
    }
DisplayAllPosts();
    ?>
</body>
<?php include("footer.php");?>
