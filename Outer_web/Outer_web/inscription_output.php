<?php
include("functions.php"); //on n'inclut pas le header donc on doit inclure les fonctions
ConnectDatabase();
$newAccountStatus = CheckNewAccountForm();
?>

<?php
    if($newAccountStatus["Successful"]){ //si il n'y a pas d'erreur dans le formulaire d'inscription
        //var_dump($newAccountStatus); //
        CreateLoginCookie($_POST["texte_email"], $_POST["mdp"],$newAccountStatus["id"]);
        echo $newAccountStatus["id"];
    }
    elseif ($newAccountStatus["Attempted"]){//sinon on ne créé pas de cookie
        //var_dump($newAccountStatus);
        echo'attempted';
    }
    DisconnectDatabase();
?>


