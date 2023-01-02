<link rel="stylesheet" href="css/style.css" type="text/css">
<?php

use Composer\web\AuthorizationClass;

$title="Регистрация";
require_once "html/header.html";
require_once "AuthorizationClass.php";

$warning=false;

//if we try to create new user
if(isset($_POST["password_2"])){
    //check username and e-mail
    if(!AuthorizationClass::isNewUser() || !AuthorizationClass::isNewEmail() ){
        $warning=true;
    }
    else {
        //creation was successful
        AuthorizationClass::Cookie("set");
        header('Location: main_page.php');
    }
}

require_once "body_registration.html";