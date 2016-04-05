<?php
$mysql_adresse = "localhost";
$mysql_dbname = "vl_extension";
$mysql_user = "root";
$myql_pass = "";
$db =  mysql_connect($mysql_adresse,$mysql_user,$mysql_pass);
mysql_select_db($mysql_dbname, $db);
#mysql_set_charset('utf8');

#unset($db);
$db = new PDO('mysql:host='.$mysql_adresse.';dbname='.$mysql_dbname.';charset=utf8',$mysql_user,$mysql_pass)
$db->exec("set names utf8");
?>
