<?php 
require __DIR__ . '/vendor/autoload.php';
include_once('./myvars.php');
include_once('./myPhpFunctions.php');

$db = new \PDO('mysql:dbname=mobileeeg1_authdb;host=localhost;charset=utf8mb4', 'mydbuser', 'HgqcPvny39KSkCEf');
$auth = new \Delight\Auth\Auth($db,null,null,False);

?>