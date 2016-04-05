<?php

if(isset($_GET['logout'])){ unset($_SESSION['TUW_UID']); }

if(isset($_POST['submitLogin'])){
	
	$x = 0;
	
	if($_POST['user']=='user' and $_POST['pass']=='pass') {
		//Keine Eintraege in Benutzer oder Passwortfeld
		$warn = "<span style='color:red;'>Bitte Benutzernamen und Passwort angeben!</span>";
		$x++;
	}
	else {
		
		$sql = "SELECT vl_journal, journal_mail FROM vl_journal WHERE journal_mail = '".$_POST['user']."' AND journal_pass = '".md5($_POST['pass'])."';";
		$erg = $db->query($sql);
		$row_lit = $erg->fetch(PDO::FETCH_OBJ);
		#echo $sql;
		
		if(isset($row_lit)){ #User aus t_user
			$_SESSION['repositum_user']=$row_lit->vl_journal;
			$_SESSION['repositum_mail']=$row_lit->journal_mail;
		}
		else{
					
			$login_warn = "<span style='color:red;'>Benutzernamen und/oder Passwort nicht korrekt!</span>";
			$x++;
		}
	}


?>

<?php if(isset($login_warn)){ echo "<p style='margin:10px 0 0 0; font-weight:bold;'>".$login_warn."</p>"; } ?>

<?php
	//Einblendung des LoginForms wenn Fehler bei Authentifizierung
	if(isset($x) and $x>0){
	echo "<script language='javascript'>$('#login').show();</script>";	
	}
?>
<script language="javascript">
var clickHandler = "click";

if('ontouchstart' in document.documentElement){
    clickHandler = "touchend";
}

$('#login_click').bind(clickHandler,function(e) {
	$('#login').show();	
	$('#username').focus();
});
</script>
