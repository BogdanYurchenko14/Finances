<link rel="stylesheet" href="style.css" type="css">

<?php

use Composer\web\AccountClass;
use Composer\web\BdRecordsClass;

require_once 'BdRecordsClass.php';
$warning = false;
//if we have new account
if(isset($_POST["name"])){
    require_once "AccountClass.php";
    if(AccountClass::isNewName()){
        BdRecordsClass::createNewRecord('account',BdRecordsClass::ACCOUNT_COLUMN_NAMES);
        header('Location: main_page.php');
    }
    else
        $warning = true;
}


require_once "AuthorizationClass.php";
$title="Создание нового счета";
require_once "header.html";
require_once 'body_account_write.html';
require_once "footer.html";
?>