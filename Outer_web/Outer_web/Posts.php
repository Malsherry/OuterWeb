<?php
include("./header.php");
$loginStatus = CheckLogin();
//include("./whenID.php");

//Try to get user for ID used as GET parameter
$blogOwnerName = "";
$isMyOwnBlog = false;
$connected=0;$isReal=0;

if ( isset($_GET["userID"]) ){ //on check si on a un id d'utiliateur quelconque
    $query = 'SELECT `surnom` FROM `utilisateurs` WHERE `ID` ='.$_GET["userID"];
    //query qui est utilisée dans les deux cas
    if(isset($_COOKIE["id"])){
        $user_id = $_COOKIE["id"];  //si ya un truc qui déconne c'est peut etre a cause de ca et de sa {}
        $connected=1;$isReal=1;

        if ($user_id == $_GET["userID"] ){ //cas ou cette page est mon blog et que je suis connecté
            $isMyOwnBlog = true; //c'est donc mon blog

            $doQuery = $db->query($query);//on effectue la requête
            $row = $doQuery->fetch_assoc();//on divise le résultat en cases pour le lire facilement
            $username = $row["surnom"]; //l'username prend la valeur de la case "surnom"
            $blogOwnerName = $username; //variable plus simple
        }

        else { //si c'est le blog de quelqu'un d'autre et que je suis connecté
            $result = $db->query($query);
		    if($result){ //si on a un résultat on va le chercher
			    $row = $result->fetch_assoc();
			    if($row){
				    $blogOwnerName = $row["surnom"];
			    }
		    }        
         // if ( mysqli_num_rows($result) != 0 ){ $blogOwnerName = $result->fetch_assoc()["surnom"];}
        }
    }
    //J'utilise la fonction EXISTS pour voir si l'id de l'utilisateur est dans la bdd ou pas.
    //Cela permet de faire deux erreurs différentes si l'utilisateur n'est pas connecté ou si le profil n'existe pas
    $existQuery = "SELECT * FROM `utilisateurs` WHERE `ID` ='".$_GET["userID"]."' AND EXISTS (SELECT * from `utilisateurs` WHERE `ID` ='".$_GET["userID"]."')";
    $exist = $db->query($existQuery);
    

    if($exist != "" && $connected==0 ){//on demande la page de quelqu'un qui existe mais on est pas connecté
        echo'<h1> Connectez-vous pour voir la page des gens :)</h1>';
        $doQuery = $db->query($query);
        $row = $doQuery->fetch_assoc();
        $blogOwnerName=$row["surnom"];
        $isReal=1;
    }
    elseif($isReal==0){ //on demande la page de qq qui n'existe pas
    //on peut avoir cette erreur en modifiant le lien mannuellement avec un id qui n'existe pas dans la bdd
        echo "<h1>Erreur! Cette ID ne correspond à aucun utilisateur actif!</h1>";
    }



    if ($blogOwnerName != "" && $connected==1) //si 
    { 
        if ($isMyOwnBlog==true){
            echo "<h1 class='welcome' >Mon profil à moi, ".$blogOwnerName."</h1>";
            echo'<p>Envie de se déconnecter? Cliquez <a class = "lien" href="logout.php">Ici</a> </p>';
            include ("./profil.php");
            echo "<h1 class='welcome' >Mes posts</h1>";

        }
        else {
            echo "<h2>Bienvenue sur la page de ".$blogOwnerName."</h2>";
        }
        DisplayPostsPage( $_GET["userID"] , $blogOwnerName, $isMyOwnBlog);
    }
}
else{echo'<p class=noCo> Connectez vous pour voir vos posts </p>';}
DisconnectDatabase();
include("footer.php");
?>