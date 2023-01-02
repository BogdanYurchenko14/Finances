<link rel="stylesheet" href="css/style.css" type="text/css">
<?php

use Composer\web\AuthorizationClass;

$title="Вход";
require_once "html/header.html";
require_once "AuthorizationClass.php";


$warning=false;

//if we try to log in
if(isset($_POST["username"])){
    //if this user exists
    if(AuthorizationClass::isUserExists()){
        setcookie('username',$_POST["username"]);
        header("Location: main_page.php");
    }
    else
        $warning=true;

}
require_once "html/body_login.html";