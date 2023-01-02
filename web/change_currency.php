<?php

use Composer\web\AccountClass;
use Composer\web\AuthorizationClass;

require_once "AccountClass.php";
//if we change to account-currency, we take data from the database
if($_POST["currency"]==AccountClass::getCurrency()){
    require_once "AuthorizationClass.php";
    setcookie("cashBalance",'',time());
    AuthorizationClass::getBalance();
}
//else we use api
else{
    $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$_COOKIE['currency']; //our past currency
    $response_json = file_get_contents($req_url);

    if(false !== $response_json) {
        $response_object = json_decode($response_json);
        if($_POST["currency"]=="USD")
            $new_price = round(($_COOKIE["cashBalance"] * $response_object->rates->USD), 2);
        if($_POST["currency"]=="EUR")
            $new_price = round(($_COOKIE["cashBalance"] * $response_object->rates->EUR), 2);
        if($_POST["currency"]=="RUB")
            $new_price = round(($_COOKIE["cashBalance"] * $response_object->rates->RUB), 2);
        setcookie('cashBalance', $new_price);
    }
}
setcookie('currency',$_POST["currency"]);
setcookie('reload',true);

header('Location: ' . $_SERVER['HTTP_REFERER']);