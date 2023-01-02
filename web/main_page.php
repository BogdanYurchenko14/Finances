<link rel="stylesheet" href="css/style.css" type="text/css">
<?php

use Composer\web\AccountClass;
use Composer\web\AuthorizationClass;
use Composer\web\BdRecordsClass;

require_once "AuthorizationClass.php";
require_once "BdRecordsClass.php";
require_once 'AccountClass.php';
$accounts = BdRecordsClass::getRecords('account');

if(isset($_POST['account'])){
    setcookie('account',$_POST['account']);
    setcookie('currency',AccountClass::getCurrency($_POST['account']));
    setcookie("cashBalance",'',time());
    header('Location: main_page.php');
}
if(!isset($_COOKIE['account']) and $accounts!=null){
    setcookie('account',$accounts[0]['name']);
    setcookie("cashBalance",'',time());
    setcookie('currency', AccountClass::getCurrency($accounts[0]['name']));
    header('Location: main_page.php');
}


//if we have new user
if(isset($_COOKIE["password_2"])){
    $tableName="users";
    $columns=BdRecordsClass::USER_COLUMN_NAMES;
    BdRecordsClass::createNewRecord($tableName,$columns);
    AuthorizationClass::Cookie("unset");
    header("Location: main_page.php");
}


$title="Главная";
require_once "html/header.html";
require_once "html/body_main.html";
require_once "html/footer.html";