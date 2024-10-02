<?php
include ("./header.php");
$result = false;
//include("./functions.php");
if( isset($_POST["action"]) ){
echo"on a le action";
if (isset($_POST["nom_post"]) && isset($_POST["description"])) { //on vérifie quand même que l'utilisateur a tout rempli

  // si un fichier a été sélectionné
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

    //on vérifie qu'il n'y a pas eu une erreur
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";

          // si tout va bien on upload l'image
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

  $nom_post = SecurizeString_ForSQL($_POST["nom_post"]); //on met le nom et la description dans des variables pour les utiliser
  $description = SecurizeString_ForSQL($_POST["description"]);

  // On modifie le titre ou la description du post même si l'image n'est pas modifiée
  if (isset($_POST['id'])) {
      $postID = $_POST['id'];
      $query = "SELECT * FROM `post` WHERE `id` = $postID";
      $result = $db->query($query);
      $row = $result->fetch_assoc();

      if ($_POST["action"] == "edit") {
          $query = "UPDATE `post` SET 
                    `date_post` =  CURRENT_TIMESTAMP,
                    `nom_post` = '$nom_post',  
                    `description` = '$description'
                    ".$img_query."
                    WHERE `id` = $postID";
                    $result = $db->query($query);

      }
  } else {
      // on crée un nouveau post
      if ($_POST["action"] == "new") {
          $query = "INSERT INTO `post` VALUES
              (NULL,'$nom_post','$description','".$_COOKIE['id']."',
              '$target_file', CURRENT_TIMESTAMP)"; //current_timestamp va mettre tout seul la bonne heure via la bdd
          $result = $db->query($query);
        }
    }



    //on fait la query pour mettre les fichiers sur la bdd
  //big parenthese
  if ($result === false || mysqli_affected_rows($db) == 0) //si rien a été ajouté a la bdd alors il y a une erreur
      {
        $error = ("Erreur lors de la insertion SQL. Essayez un nom/password sans caractères spéciaux");
      }
  else //si on a des nouveau éléments dans la bdd c'est que ça s'est bien passé
        {
        $creationSuccessful = true;  
        $redirect = "Location:Posts.php?userID=".$_COOKIE["id"].""; //on est renvoyé sur la page 
        header($redirect);
        DisconnectDatabase();
        }
      }
  if( $_POST["action"] == "delete" ){
    $postID = $_POST["id"];
    $query = "DELETE FROM `post` WHERE `id` = $postID";
    $result = $db->query($query);
    $redirect = "Location:Posts.php?userID=".$_COOKIE["id"].""; //on est renvoyé sur la page 
    header($redirect);

  }
  
}
