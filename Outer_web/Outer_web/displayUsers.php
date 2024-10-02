<?php
/*Une query qui permet de retourner le nom et l'id de tous les utilisateurs dans l'ordre alphabétique*/
    $query = "SELECT `id`,`surnom` FROM `utilisateurs` ORDER BY surnom ASC";
    $result = $db->query($query);

    if( mysqli_num_rows($result) != 0 ){ //si on a bien un résultat (il peut n'y avoir aucun utilisateur dans la bdd)
        echo "<ul>";
        while( $row = $result->fetch_assoc() ) {
            echo '<li class=lien> <a class=lien href="./Posts.php?userID='.$row["id"].'">'.$row["surnom"].'</a></li>';
        }
        echo "</ul>";
    }
    else {//dans le cas ou il n'y a aucun utilisateurs, on l'affiche
        echo '<p class="warning"> Aucun utilisateur/blog n\'existe dans le système pour l\'instant!</p>';
    } 
?>
    