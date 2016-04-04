<?php
$mysql_adresse = "";
$mysql_dbname = "";
$mysql_user = "";
$myql_pass = "";
$db =  mysql_connect($mysql_adresse,$mysql_user,$mysql_pass);
mysql_select_db('TUW', $db);

$db = new PDO('mysql:host='.$mysql_adresse.';dbname='.$mysql_dbname.';charset=utf8',$mysql_user,$mysql_pass);
$db->exec("set names utf8");
?>
