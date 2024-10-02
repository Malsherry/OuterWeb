<?php
    if ( $loginStatus["Successful"] == false ) {
        $redirect = "Location:Index.php";
        header($redirect);
        echo("login pas successful ");
    }
?>