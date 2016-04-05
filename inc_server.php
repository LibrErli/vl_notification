<?php
#Informationen zum Datenbankserver
$mysql_adresse = "localhost";
$mysql_dbname = "vl_extension";
$mysql_user = "root";
$mysql_pass = "";

#Adresse des Webservers auf dem die PHP-Skripten gehosten werden (wird bspw. in inc_notific.php für die unsubscribe-Infos benutzt)
$web_adresse = "http://";

$db = new PDO('mysql:host='.$mysql_adresse.';dbname='.$mysql_dbname.';charset=utf8',$mysql_user,$mysql_pass);
$db->exec("set names utf8");
?>
