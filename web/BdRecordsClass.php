<?php

namespace Composer\web;

use RedBeanPHP\R;

//connecting the db
require 'index.php';


class BdRecordsClass
{
    const MONTH = [
        '1' => 'Январь',
        '2' => 'Февраль',
        '3' => 'Март',
        '4' => 'Апрель',
        '5' => 'Май',
        '6' => 'Июнь',
        '7' => 'Июль',
        '8' => 'Август',
        '9' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь'
    ];
    const USER_COLUMN_NAMES = ['username', 'email', 'password'];
    const ACCOUNT_COLUMN_NAMES = ['user_id', 'name', 'currency'];
    const COLUMN_NAMES = ['user_id', 'account_id', 'name', 'category', 'count', 'date'];
    const CATEGORY_EXPENSE = [
        "noName" => "Без названия",
        "entertainment" => "Развлечение",
        "food" => "Еда",
        "health" => "Здоровье",
        "other" => "Другое"];
    const CATEGORY_INCOME = [
        "noName" => "Без названия",
        "job" => "Работа",
        "sale" => "Продажа",
        "present" => "Подарок",
        "winning" => "Выигрыш",
        "other" => "Другое"];
    const DATE_FILTER = [
        "1month" => "Месяц",
        "3month" => "3 Месяца",
        "year" => "Год",
        "all" => "За все время"];

    static function createNewRecord($tableName, $columns)
    {
        $table = R::dispense($tableName);

        //if we create user record
        if ($columns == self::USER_COLUMN_NAMES) {
            foreach ($columns as $column) {
                $table->$column = $_COOKIE[$column];
            }
        } //if we create new account
        else if ($columns == self::ACCOUNT_COLUMN_NAMES) {
            foreach ($columns as $column) {
                if ($column == "user_id") {
                    $table->$column = self::getUserId();
                } else
                    $table->$column = $_POST[$column];
            }

        } //if we create income/expense record
        else {
            foreach ($columns as $column) {
                if ($column == "user_id") {
                    $table->$column = self::getUserId();
                } else if ($column == "account_id") {
                    $table->$column = self::getAccountId();
                } else
                    $table->$column = $_POST[$column];
            }
        }


        R::store($table);
    }


    static function getRecords($tableName, $category = 0, $month = 0, $findcategory = 0, $method = 0)
    {
        require_once 'FilterClass.php';

        if ($category != 0)
            $filters = FilterClass::setFilter($category, $month, $findcategory, $method);

        $user_id = self::getUserId();
        $account_id = self::getAccountId();

        $request = "SELECT * FROM {$tableName} WHERE user_id = '{$user_id}'";
        if ($tableName != "account") {
            $request .= " AND account_id='{$account_id}'";
        }
        //if we have filter
        if ($filters['date'] != null or $filters['category'] != null) {
            $request .= " AND ";

            if ($filters["date"] != null)
                $request .= $filters['date'];

            if ($filters['date'] != null and $filters['category'] != null)
                $request .= " AND ";

            if ($filters["category"] != null)
                $request .= $filters['category'];

        }
//        echo $request;
        $all_records = R::getAll($request);

        //if we got no one records
        if ($all_records == null and $tableName != "account") {
            $all_records = self::getNullRecord();
        }

        return $all_records;
    }

    private static function getNullRecord()
    {
        $all_records[0]['name'] = "Нет информации";
        $all_records[0]['category'] = "Без категории";
        $all_records[0]['count'] = "0";
        $all_records[0]['date'] = "-";
        return $all_records;
    }

    static function getSumCount($all_records)
    {
        $sum = 0;
        foreach ($all_records as $value) {
            $sum += $value["count"];
        }
        R::close();
        return $sum;
    }

    static function getUserId()
    {
        $res = R::getAll("SELECT id FROM users WHERE username = '{$_COOKIE['username']}'");
        return $res[0]["id"];

    }

    static function getAccountId()
    {
        $res = R::getAll("SELECT id FROM account WHERE name = '{$_COOKIE['account']}'");
        return $res[0]["id"];

    }

}
