<?php

namespace Composer\web;
use R;

class AccountClass
{
    static function isNewName()
    {
        require_once 'BdRecordsClass.php';
        $user_id = BdRecordsClass::getUserId();
        return R::getAll("SELECT * FROM account WHERE name='{$_POST['name']}' and user_id='{$user_id}'") == null;
    }

    static function getCurrency($name = 0)
    {
        require_once 'BdRecordsClass.php';
        $user_id = BdRecordsClass::getUserId();
        if ($name == 0)
            return R::getAll("SELECT currency FROM account WHERE name='{$_COOKIE['account']}' and user_id='{$user_id}'")[0]['currency'];
        else
            return R::getAll("SELECT currency FROM account WHERE name='{$name}' and user_id='{$user_id}'")[0]['currency'];
    }
}