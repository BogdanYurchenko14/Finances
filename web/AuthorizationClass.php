<?php

namespace Composer\web;

use R;

class AuthorizationClass
{


    static function isAutorized()
    {
        return $_COOKIE["username"];
    }

    static function isNewUser()
    {
        require_once 'BdRecordsClass.php';
        return R::getAll("SELECT * FROM users WHERE username='{$_POST['username']}'") == null;
    }


    static function isNewEmail()
    {
        require_once 'BdRecordsClass.php';
        return R::getAll("SELECT * FROM users WHERE email='{$_POST['email']}'") == null;
    }


    static function Cookie($method)
    {
        if ($method == "set") {
            setcookie('username', $_POST["username"]);
            $t = time() + 3600;
        } else $t = time();
        setcookie('email', $_POST["email"], $t);
        setcookie('password', md5($_POST["password"]), $t);
        setcookie('password_2', md5($_POST["password_2"]), $t);
    }


    static function isUserExists()
    {
        require_once 'BdRecordsClass.php';
        $password = md5($_POST['password']);
        return R::getAll("SELECT * FROM users WHERE username='{$_POST['username']}' and password='{$password}'") != null;
    }

    static function getBalance($name = 0)
    {
        if (isset($_COOKIE['cashBalance']))
            return $_COOKIE['cashBalance'];
        require_once 'BdRecordsClass.php';
        $all_income = BdRecordsClass::getSumCount(BdRecordsClass::getRecords('income', BdRecordsClass::CATEGORY_INCOME, 0, 0, "all"));
        $all_expense = BdRecordsClass::getSumCount(BdRecordsClass::getRecords('expenses', BdRecordsClass::CATEGORY_EXPENSE, 0, 0, "all"));
        setcookie('cashBalance', $all_income - $all_expense);
        require_once 'AccountClass.php';
        setcookie('currency', AccountClass::getCurrency($name));
        return $all_income - $all_expense;
    }
}