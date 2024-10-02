<?php
include ("./functions.php");
ConnectDatabase();

if (isset($_POST["mdp"]) && isset($_POST["texte_email"]))
{
    $loginStatus = CheckLogin();

    if ( $loginStatus["Successful"] ) {

        $user_id=$loginStatus['id'];
        CreateLoginCookie($_POST["texte_email"], $_POST["mdp"],$user_id);
	    $redirect = "Location:Posts.php?userID=".$loginStatus["id"];
	    header($redirect);
        DisconnectDatabase();
    }
}?>

