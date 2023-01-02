<link rel="stylesheet" href="css/style.css" type="text/css">
<?php

use Composer\web\BdRecordsClass;

require_once "AuthorizationClass.php";
require_once "AccountClass.php";
$nextYear=true;

//today's year
if(!isset($_COOKIE['year'])){
    setcookie('year',date('Y'));
    header("Location: statistics_page.php");
}

//changing the year
else if(isset($_POST["changeYear"])){
    if($_COOKIE['year']!=date('Y') or $_POST["changeYear"]!=1){
        setcookie('year', $_COOKIE['year']+=$_POST["changeYear"]);
        header("Location: statistics_page.php");
    }


}

if($_COOKIE[year]==date('Y') )
    $nextYear=false;


//calculations for months
require_once "BdRecordsClass.php";
$statistics=array();
foreach(BdRecordsClass::MONTH as $key => $value){
    $statistics+=["{$key}-expense" => BdRecordsClass::getSumCount(BdRecordsClass::getRecords('expenses',BdRecordsClass::CATEGORY_EXPENSE,$key)) ];
    $statistics+=["{$key}-income" => BdRecordsClass::getSumCount(BdRecordsClass::getRecords('income',BdRecordsClass::CATEGORY_INCOME,$key)) ];
    $statistics+=["{$key}-total" => $statistics["{$key}-income"]- $statistics["{$key}-expense"]];
}

//calculations for year
$all_expense = BdRecordsClass::getRecords("expenses",BdRecordsClass::CATEGORY_EXPENSE);
$all_income = BdRecordsClass::getRecords("income",BdRecordsClass::CATEGORY_INCOME);

$sumOfAllExpense=BdRecordsClass::getSumCount($all_expense);
$sumOfAllIncome=BdRecordsClass::getSumCount($all_income);
$totalSum= $sumOfAllIncome-$sumOfAllExpense;



$title="Статистика за {$_COOKIE['year']} год";
require_once "html/header.html";




$columns=["1"=>"Доходы:", "2" => "Расходы:","3"=> "Итог:"];
require_once "statistics_body.html";
require_once "footer.html";