<?php
include_once "inc_server.php";

$subscribe_mail_subject = "";
$subscribe_mail_body = "";
/*
Um den Mailtext zu personalisieren, können die Variablen des Formulars bspw. wie folgend eingebaut werden:
$subscribe_mail_body = 'Sehr geehrte/r '.$_GET['firstname'].' '.$_GET['username'].'! [...]';
*/


$sql = "SELECT email FROM vl_notific_maildata WHERE vl_journal = '".$_GET['vl_journal']."' AND email = '".$_GET['email']."';";

$erg = $db->query($sql);
if($erg->rowCount()>0){
	$ret = array("sysinfo" => "vorhanden");
}
else {
	
	$daten = array("vl_journal" => $_GET['vl_journal'], "email" => $_GET['email'], "institution" => $_GET['institution'], "name" => $_GET['username'], "firstname" => $_GET['firstname']);
	$sql = "INSERT INTO vl_notific_maildata (vl_journal, email, institution, name, vorname) VALUES (:vl_journal, :email, :institution, :name, :firstname);";
	$erg = $db->prepare($sql);
	$erg->execute($daten);
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
	$headers .= "FROM: oes@tuwien.ac.at\r\nCC: christian.erlinger-schiedlbauer@tuwien.ac.at";
	
	mail($_GET['email'],$subscribe_mail_subject,$subscribe_mail_body,$headers);
	
	$ret = array("sysinfo" => "Eingetragen");
}

$json_ret = json_encode($ret);
$callback = $_GET['callback'];
echo $callback."('".addslashes($json_ret)."');";
?>
