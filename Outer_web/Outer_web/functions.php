<?php
//--------------------------------------------------------------------------------
$rootpath = "localhost/user";

function CheckNewAccountForm()
{
    global $db;
    $result=false;
    $creationAttempted = false;
    $creationSuccessful = false;
    $error = NULL;
    $id=NULL;

    //Données reçues via formulaire?
    if(isset($_POST["texte_nom"]) && isset($_POST["texte_prenom"]) && isset($_POST["texte_surnom"]) && isset($_POST["texte_email"]) && isset($_POST["confirm"]) && isset($_POST["mdp"]))
    {
    //vibecheck de l'image
        if (isset($_FILES["img"]) && $_FILES["img"]["size"] > 0) {

            var_dump($_FILES["img"]);
            $target_dir = "uploads/"; //là où on va mettre les images qui sont postées
            $target_file = $target_dir . basename($_FILES["img"]["name"]); //path de l'image qu'on veut upload
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); //type de l'extension 
      
            // on veut pas que l'utilisateur mette autre chose qu'une image ou un gif donc
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
                $error = ("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                $uploadOk = 0;
            }
      
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
      
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["img"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
      
            //mettre la variable $target_file qui contient le path de l'image dans la requête SQL
            $img_query = ",`img` = '$target_file'";
        } else {
            //aucun fichier n'a été sélectionné, ne pas modifier l'image
            $img_query = "";
        }

        //Pour l'image^^^^^^

        $creationAttempted = true;
        $selectMail = mysqli_query($db, "SELECT * FROM utilisateurs WHERE mail = '".$_POST["texte_email"]."'");
        $selectSurname = mysqli_query($db, "SELECT * FROM utilisateurs WHERE surnom ='".$_POST["texte_surnom"]."'");

        //Form is only valid if password == confirm, and username is at least 4 char long
        if(mysqli_num_rows($selectMail)) {
            echo "
            <script>
                alert('Cette adresse email est déjà utilisée \\n Vous allez être redrigé');
                window.location.href = 'inscription.php';
            </script>";
        }
        else if(mysqli_num_rows($selectSurname)){
            echo "
            <script>
                alert('Surnom déjà pris \\n Vous allez être redirigé');
                window.location.href = 'inscription.php';
            </script>";
        }
        elseif ( $_POST["mdp"] != $_POST["confirm"] ){
            echo "
            <script>
                alert('Le mot de passe et sa confirmation sont différents \\n Vous allez être redirigés');
                window.location.href = 'inscription.php';
            </script>";
        }
        else{
            $surnom = SecurizeString_ForSQL($_POST["texte_surnom"]);
            $mdp = md5($_POST["mdp"]);
            $prenom = SecurizeString_ForSQL($_POST["texte_prenom"]);
            $nom = SecurizeString_ForSQL($_POST["texte_nom"]);
            $mail = SecurizeString_ForSQL($_POST["texte_email"]);
            $query = "INSERT INTO `utilisateurs` VALUES (NULL , '$mail' , '$surnom' , '$nom' , '$prenom' , '$mdp','$target_file' )";
            $result = $db->query($query);
        }
        if ($result === false || mysqli_affected_rows($db) == 0) {
            echo "
            <script>
                alert('Erreur lors de l\\'insertion SQL. Essayez un nom/password sans caractères spéciaux');
                window.location.href = 'inscription.php';
            </script>";
        }
        else{
            $creationSuccessful = true;
            $wantID = "SELECT id FROM utilisateurs WHERE mail='".$mail."' AND mdp='".$mdp."'";
            $resultID= $db->query($wantID);
            $id=$resultID->fetch_assoc();//on accede a la permiere ligne de la query
            echo "
            <script>
                alert('Votre compte a été créé avec succès');
                window.location.href = 'Index.php';
            </script>";


        }
        
    }
    else 
    {
        echo "<script>alert('Tous les champs doivent être remplis');</script>";
    }
    
    $resultArray = ['Attempted' => $creationAttempted, 
                    'Successful' => $creationSuccessful, 
                    'ErrorMessage' => $error,
                    'id'=>$id["id"]];

    return $resultArray;
}






//<button onclick="myFunction()">Try it</button>
echo'
<script>
function wrongmdp() {
  alert("I am an alert box!");
}
</script>';

function ConnectDatabase(){
    // Create connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "user";
    global $db;
    
    $db = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
    }
}


function SecurizeString_ForSQL($string) {
    $string = trim($string);
    $string = stripcslashes($string);
    $string = addslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

 //Function to close connection to database
//--------------------------------------------------------------------------------
function DisconnectDatabase(){
	global $db;
	$db->close();
}



//--------------------------------------------------------------------------------
function CheckLogin(){
    global $db, $mail, $userID;
    $error = NULL; 
    $loginSuccessful = false;

    //Données reçues via formulaire?
	if(isset($_POST["texte_email"]) && isset($_POST["mdp"])){

        $mail = SecurizeString_ForSQL($_POST["texte_email"]);
		$mdp = md5($_POST["mdp"]);

        //on choppe l'id
        $wantID = "SELECT id FROM utilisateurs WHERE mail='".$mail."' AND mdp='".$mdp."'";
        $resultID= $db->query($wantID);
        $userID=$resultID->fetch_assoc();//on accede a la permiere ligne de la query
        
		$loginAttempted = true;
	}
	//Données via le cookie?
	elseif ( isset( $_COOKIE["texte_email"] ) && isset( $_COOKIE["mdp"] ) ) {

		$mail = $_COOKIE["texte_email"];
		$mdp = $_COOKIE["mdp"];
		$loginAttempted = true;
	}
	else {
		$loginAttempted = false;
	}

    //Si un login a été tenté, on interroge la BDD
    if ($loginAttempted){
        $query = "SELECT * FROM utilisateurs WHERE mail = '".$mail."' AND mdp='".$mdp."'";
        $doQuery = $db->query($query); // fait la requête
        $result=$doQuery->fetch_assoc();

        if ( $result != false ){

            $userID= $result['id'];
            CreateLoginCookie($mail,$mdp,$userID);
            $loginSuccessful = true;
        }
        else {
            //header('refresh:10;url=tapage.php');
            echo"oui";
            $redirect = "Location:error.php";
            header($redirect);
            //echo "<script language='JavaScript'>alert('Mdp foiré !!')</script>";
            //echo ' "<span> "Ce couple mail/mot de passe nexiste pas. Créez un Compte"</span>';
        }
    }
    
	
	$resultArray = ['Successful' => $loginSuccessful, 
					'Attempted' => $loginAttempted, 
					'ErrorMessage' => $error,
					'id' => $userID];

    return $resultArray;
}

//Méthode pour créer/mettre à jour le cookie de Login
//--------------------------------------------------------------------------------
function CreateLoginCookie($name, $encryptedPasswd,$userID){
    setcookie("name", $name, time() + 24*3600 );
    setcookie("mdp", $encryptedPasswd, time() + 24*3600);
    setcookie("id", $userID, time() + 24*3600);

}

//Méthode pour détruire les cookies de Login
//--------------------------------------------------------------------------------
function DestroyLoginCookie(){
    setcookie("name", NULL, -1 );
    setcookie("mdp", NULL, -1);
    setcookie("id", NULL, -1);

}

function DisplayPostsPage($blogID, $ownerName, $isMyBlog){
    global $db;

    $query = "SELECT * FROM `post` WHERE `id_user` = ".$blogID." ORDER BY date_post DESC";//DESC LIMIT 10";
    $result = $db->query($query);

        $count=0;

        

        while($row = $result->fetch_assoc())
        {
            $count +=1;
            echo '<div class="blogPost"> ';//<div class="postTitle">
            $timestamp =$row["date_post"];
//le programme râlait si je lui demandais la date via php alors je lui demande via mysql

            if ($isMyBlog){

                echo '
                <div class="postModify">
                    <form action="editPost.php" method="GET">
                        <input type="hidden" name="id" value="'.$row["id"].'">
                        <button type="submit">Modifier/effacer</button>
                    </form>
                </div>';
            }
            else {
                echo '
                <div class="postAuthor">Posté par '.$ownerName.'</div>
                ';
            }
   
//truc pour mettre la last modif
            $image = $row["img"];
            echo '<div class=postStyle>
                <p class="postTitle">'.$row["nom_post"].'</p>
                  <p class="modif_time">dernière modification le '.$timestamp.'</p>
                  <p class="postContent">'.$row["description"].'</p>
                  <img class="post_pic" src="'.$image.'" alt="texte alternatif" /> 
                <br>
                </div>';
        }
  
        if ($isMyBlog){
            if($count == 0){
                echo '<form action="new_post.php" method="POST">
                <input type="hidden" name="newPost" value="1">';
                echo '<p>Il n\'y a pas de post dans ce blog.</p>';
                echo'<button type="submit">Ajouter un premier post!</button> </form>';
            }else{
                echo '
                <form action="new_post.php" method="POST">
                <input type="hidden" name="newPost" value="1">
                <button type="submit">Ajouter un nouveau post!</button>
                </form>';
            } 
    }    
} 
?>

