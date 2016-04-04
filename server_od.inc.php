<?php
$db =  mysql_connect("localhost","wwwdata","!!wwwub1040!!");
mysql_select_db('TUW', $db);
#mysql_set_charset('utf8');

#unset($db);
$db = new PDO('mysql:host=localhost;dbname=TUW;charset=utf8','wwwdata','!!wwwub1040!!');
$db->exec("set names utf8");
?>
