<link rel="stylesheet" href="css/style.css" type="text/css">

<?php

use Composer\web\BdRecordsClass;

require_once "AuthorizationClass.php";
$title="Создание новой записи";
require_once "header.html";

require_once 'BdRecordsClass.php';

$listName="Прибыль";
$category =BdRecordsClass::CATEGORY_INCOME;
require_once 'body_write.html';




require_once "footer.html";
?>