<?php
  $afficher_profil = $db->query("SELECT * FROM utilisateurs WHERE id = " . $_COOKIE['id']);
  $afficher_profil = $afficher_profil->fetch_assoc(); 
//<h1>Bienvenue <?php echo $afficher_profil['nom'];</h1>?>

<div class=profil_page>
<a href="logout.php"><img class=sticky src="./Style/Images/logout.png"></a><br><br>
<a href="new_post.php"><img class=sticky_post src="./Style/Images/new.png"></a></div>
<div style='display:flex'> <img src="<?php echo $afficher_profil['pp']; ?>" class="rond"> </div>
<!--si je laisse rond dans la div profil_page alors l'image devient elle aussi sticky ce que je ne veux pas-->
