<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<meta name="revisit-after" content="2 days" >
<meta name="robots" content="index,follow" >
<meta name="author" content="Universit&auml;tsbibliothek der TU Wien">
<script src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "#bodytext",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
	extended_valid_elements : 'span',
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
<link rel="stylesheet" href="style.css">
<title>VL-Extension Backend</title>

</head>
<body>  
        
<!-- Menu Links -->
<div id="side-bar" >
		
<?php
include_once "inc_server.php";
include_once "inc_login.php";


if(isset($_SESSION['repositum_user'])){
	echo "<span class='menu_header'>VL-Extension - Backend</span>";
	echo "<ul class='main_menu'>";
	echo "<li><a href='?notific'>Abonnentenverwaltung</a></li>";	
	echo "<li><a href='?notific_mail'>Benachrichtigungen</a></li>";
	echo "<li><a href='?page_edit'>Page-Editor</a></li>";
	echo "</ul>";

}
?>
    <!-- Hier ist Platz fuer eine individuelle Navigation -->
      
</div><!-- Ende Menu Links-->

<div id="main-content"> <!--Textteil-->	
<h1>VL-Extension - Backend</h1>

<?php


#Anmelde-Formular	
if(!isset($_SESSION['repositum_user'])){
echo"
<div id='login' style='width:400px;'>
<form name='loginForm' action='".$_SERVER['PHP_SELF']."' method='post'>
	<label style='float:left; margin:10px 10px 0 0;'>Benutzername:</label> <div id='user' style='height:35px; width:300px; background-color:#ffffff;  border-radius: 3px 3px 3px 3px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) inset, 0 0px 0 rgba(255, 255, 255, 0.5); padding: 2px 2px 0px 3px; margin:20px 0 0 110px;'>
	<input type='text' id='username' value='Benutzername' name='user' onfocus=\"this.value='';\">
    </div>
    <label style=\"float:left; margin:20px 0 0 0;\">Passwort:</label> <div id='passwrd' style='height:35px; width:300px; background-color:#ffffff;  border-radius: 3px 3px 3px 3px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) inset, 0 0px 0 rgba(255, 255, 255, 0.5); padding: 2px 2px 0px 3px; margin:10px 0 0 110px;'>
	<input type=\"password\" id='pass' value='' name='pass' onfocus=\"this.value='';\">
    </div>
	<input type='submit' value='Anmelden' name='submitLogin' style='margin:15px 0 0 110px; height:35px; width:100px; background-color:#006699; border:0 none; border-radius:2px; color:#fff; cursor:pointer; ' >
    <a  href='index.php?lostpwd' name='lostPwd' style='margin:15px 0 0 0px; height:35px; display: block; line-height:35px; text-align:center; width:150px; background-color:#006699; border:0 none; border-radius:2px; color:#fff; text-decoration:none; cursor:pointer; float:right; position:relative; right:30px; ' >Passwort vergessen?</a>
</form>
</div>	";
}
else {#User erfolgreich angemeldet
	#Benachrichtigungssystem-Verwaltung
	if(isset($_GET['notific'])){ include_once "inc_notific.php";	}
	if(isset($_GET['notific_mail'])){ include_once "inc_notific_mail.php";	}
	if(isset($_GET['page_edit'])){ include_once "inc_pageedit.php";	}
			
}

?>


</div>
<!-- Textteil Ende-->

<div id="clear"></div>


</div><!--###container2col### end -->
<script>
$('#checkMark').bind(clickHandler,function(e) {
	console.log('check');
	$(".vl_maildata").each(function() { 
		if($(this).prop('checked')) { $(this).prop('checked',false); } else { $(this).prop('checked',true); }
    });
	
});
</script>
</body>
</html>

<?php
//Zusatz-Funktionen


function get_field_value($field_id,$post="",$db="",$date=false){
	
	$ret = "";
	if(isset($post[$field_id])) {
		$ret = $post[$field_id];
	}
	else if(isset($db[$field_id])){
		$ret = $db[$field_id];
	}
	if($date==true) { $ret = date('d-m-Y', strtotime($ret)); }
	return $ret;
	
}
?>