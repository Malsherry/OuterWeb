<?php
include("./functions.php");
DestroyLoginCookie();
unset($_POST);
$redirect = "Location:Index.php";
header($redirect);
?>