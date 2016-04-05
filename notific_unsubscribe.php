<!DOCTYPE html>
<html lang="de">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<meta name="revisit-after" content="2 days" >
<meta name="robots" content="index,follow" >
<meta name="author" content="Universit&auml;tsbibliothek der TU Wien">
<title>VL-Notificationsystem Unsubscribe</title>
</head>
<body>
 
<h1>Abmeldung vom Benachrichtungssystem</h1>
<?php
include_once "inc_server.php";

if(isset($_POST['unsub_ja'])){
	$sql = "DELETE FROM vl_notific_maildata WHERE email = '".$_POST['email']."' Limit 1;";
	$db->query($sql);
	echo "Sie wurden erfolgreich aus dem Benachrichtungssystem ausgetragen!";
	
}else {

	if(isset($_GET['vl_j']) and isset($_GET['email'])){
		$sql = "SELECT * FROM vl_journal WHERE vl_journal = '".$_GET['vl_j']."';";
		$erg = $db->query($sql); $row = $erg->fetch(PDO::FETCH_OBJ);
		echo "Wollen Sie sich mit der E-Mail-Adresse ".$_GET['email']." aus dem Benachrichtigungssystem des Open Access Journals ".$row->journal_name." abmelden?";
		echo"	
		<form name='unsubscribe' action='".$_SERVER['PHP_SELF']."' method='post'>
			<input type='hidden' name='email' value='".$_GET['email']."'>
			<input type='submit' name='unsub_ja' value='Ja'>
		</form>";
	}
	else { echo "Keine Parameter vorhanden!"; }
}

?>

</body>
</html>