<?php
//connecting the db
include 'info.php';

const HOST = 'localhost';
const DBNAME = 'Polina';
const USERNAME='root';
const PASSWORD='12312';

require_once'../vendor/autoload.php';
class_alias('\RedBeanPHP\R', '\R');


R::setup( "mysql:host=" . HOST . ";dbname=". DBNAME,
    USERNAME, PASSWORD, false);


if(!R::testConnection()){
    die("No connection");
}

/**
 * Если нужно работать с таблицами, в названии которых
 * присутствует знак подчёркивания (_), то необходимо воспользоваться
 * таким методом
 */
R::ext('xdispense', function( $type ){
    return R::getRedBean()->dispense( $type );
});
// Использовать так:
$test = R::xdispense('test_table');
// Code...
R::store($test);