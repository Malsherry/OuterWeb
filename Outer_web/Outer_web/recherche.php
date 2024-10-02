<?php
include("functions.php");
ConnectDatabase(); 

if (isset($_GET['query']) && $_GET['query'] != '') {
  $seek = htmlspecialchars($_GET['query']);
  $query = ('SELECT * FROM `post` WHERE `description` LIKE "%'.$seek.'%"');
  $result = $db->query($query);




while ($row = $result->fetch_assoc()) {
    $timestamp =$row["date_post"];
    $image = $row["img"];

            echo '<div class=postStyle>
                  <p class="postTitle">'.$row["nom_post"].'</p>
                  <p class="modif_time">dernière modification le '.$timestamp.'</p>
                  <p class="postContent">'.$row["description"].'</p>
                  <img class="post_pic" src="'.$image.'" alt="texte alternatif" /> 
                <br>
                </div>';
  }
}
?>




