<?php 
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); 
require __DIR__ . '/vendor/autoload.php';
include_once('./myvars.php');
include_once('./myPhpFunctions.php');

$db = new \PDO('mysql:dbname=mobileeeg1_authdb;host=localhost;charset=utf8mb4', 'root', 'passwordphpmyadmin');
$auth = new \Delight\Auth\Auth($db,null,null,False);

?>