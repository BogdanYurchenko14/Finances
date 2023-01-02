<link rel="stylesheet" href="css/style.css" type="text/css">

<?php

use Composer\web\BdRecordsClass;

require_once "BdRecordsClass.php";


//the month on the button
if(isset($_POST['month']) and $_POST['month']!=$_COOKIE['month']){
    setcookie('month', $_POST['month']);
    header("Location: detailed_statistics_page.php ");
}
$nextMonth = true;
require_once "AuthorizationClass.php";

//changing the month
if(isset($_POST["changeMonth"])){

    if($_COOKIE['month']==12 and $_POST["changeMonth"]==1){
        setcookie('year', $_COOKIE['year']+=1);
        setcookie('month', $_COOKIE['month']='1');

    }
    else if($_COOKIE['month']==1 and $_POST["changeMonth"]==-1){
        setcookie('year', $_COOKIE['year']-=1);
        setcookie('month', $_COOKIE['month']='12');

    }
    else
        setcookie('month', $_COOKIE['month']+=$_POST["changeMonth"]);
}
//calculations
$all_income=array();
$all_expense=array();
foreach (BdRecordsClass::CATEGORY_INCOME as $key => $category)
    $all_income+=["{$key}"=>BdRecordsClass::getSumCount(BdRecordsClass::getRecords('income',BdRecordsClass::CATEGORY_INCOME,$_COOKIE['month'],$key))];
foreach (BdRecordsClass::CATEGORY_EXPENSE as $key => $category)
    $all_expense+=["{$key}"=>BdRecordsClass::getSumCount(BdRecordsClass::getRecords('expenses',BdRecordsClass::CATEGORY_EXPENSE,$_COOKIE['month'],$key))];
$incomeSum= array_sum($all_income);
$expenseSum= array_sum($all_expense);
$totalSum = $incomeSum-$expenseSum;

$title="Статистика за ". BdRecordsClass::MONTH[$_COOKIE['month']] . " " . $_COOKIE['year'];
require_once "html/header.html";

if($_COOKIE['year']==date('Y') and  $_COOKIE['month']==12){
    $nextMonth = false;
}

require_once "html/detailed_statistic_body.html";

require_once "html/footer.html";