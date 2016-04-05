<?php
#Loesch-Prozeduren
		if(isset($_GET['delete_id'])) { 
			$sql = "SELECT * FROM vl_notific_maildata WHERE vl_notific_maildata_id = ".$_GET['delete_id'].";";
			$erg = $db->query($sql); $row = $erg->fetch(PDO::FETCH_OBJ);
			echo "Eintrag mit der E-Mail ".$row->email." wirklich l&ouml;schen?<br/>
				<form name='delUser' method='post' action='?notific' style='margin-bottom:20px;'>
				<input type='hidden' name='vl_notific_maildata_id' value='".$_GET['delete_id']."'/>
				<input type='submit' name='delYes' value='Ja'> <input type='submit' name='delNo' value='Nein'>
				</form>";
		}
		
		if(isset($_POST['delYes'])){
			if(isset($_POST['vl_notific_maildata_id'])){#Loeschen via vl_notific_maildata_id Value
				$sql = "DELETE FROM vl_notific_maildata WHERE vl_notific_maildata_id = ".$_POST['vl_notific_maildata_id'].";";
				$db->query($sql);
				echo "Eintrag erfolgreich gelöscht!";
			}
			else {#Loeschen via vl_mail_id-Array
				for($i=0;$i<count($_POST['vl_mail_id']);$i++){
					$sql = "DELETE FROM vl_notific_maildata WHERE vl_notific_maildata_id = ".$_POST['vl_mail_id'][$i].";";
					$db->query($sql);
					echo "Eintr&auml;ge erfolgreich gelöscht!";
				}
			}	
		}
		#Ende Loesch-Prozeduren
		
		#Notification-Mail-Prozeduren
		
		#SendMail
		if(isset($_POST['sendMail'])){
			#echo "sendMail";
			$headers = "MIME-Version: 1.0" . "\r\n";	
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			#$headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
			$headers .= "FROM: ".$_POST['from']."\r\n";							
			
			$to = "";
			for($i=0;$i<count($_POST['vl_mail']);$i++){
				$bodytext_end = "----------------------------------------------------------------------------------------------------------------------------------<br/>
Falls Sie keine Benachrichtigungen wünschen, melden Sie sich bitte unter folgendem Link ab:<br/>
<a href='".$web_adresse."notific_unsubscribe.php?vl_j=".$_SESSION['repositum_user']."&email=".$_POST['vl_mail'][$i]."'>".$web_adresse."/notific_unsubscribe</a>";

				mail($_POST['vl_mail'][$i],$_POST['subject'],$_POST['bodytext'].$bodytext_end,$headers);
			}
			
			#Sichern des Infomails in der Tabelle vl_notification_mails
			$daten = array("vl_journal" => $_SESSION['repositum_user'], "body_text" => $_POST['bodytext'], "subject" => $_POST['subject'], "datum" => date('Y-m-d H:i', time()));
			$sql = "INSERT INTO vl_notification_mails (vl_journal, mail, subject, datum) VALUES (:vl_journal, :body_text, :subject, :datum );";
			$erg = $db->prepare($sql);
			$erg->execute($daten);				
		}
			
		#New Notification-E-Mail
				
		if(isset($_POST['newInfoMail'])){
			echo "<form id='notificSubscribe' action='?notific' method='post' style='margin-bottom:14px;'>";	
			echo "<table>";	
			echo "<tr><td>Absender</td><td><input type='text' name='from' value='".$_SESSION['repositum_mail']."'></td></tr>";
			echo "<tr><td>Empfänger:</td><td>";
			if(isset($_POST['vl_mail_id'])){
				for($i=0;$i<count($_POST['vl_mail_id']);$i++){
					$sql = "SELECT * FROM vl_notific_maildata WHERE vl_notific_maildata_id = ".$_POST['vl_mail_id'][$i].";";
					$erg = $db->query($sql); 
					$row = $erg->fetch(PDO::FETCH_OBJ);
					
					echo $row->email."; ";
					echo "<input type='hidden' name='vl_mail[]' value='".$row->email."'>";
					

				}
			echo "</td></tr>";
					
			echo "<tr><td>Betreff</td><td><input type='text' name='subject'></td></tr>";
			echo "<tr><td>Text</td><td><textarea name='bodytext' id='bodytext' rows='10' cols='75'></textarea></td></tr>";					
			echo "<tr><td></td><td><input type='submit' name='sendMail' value='Abschicken!'></td></tr>";
			echo "</table>";	
			echo "</form>";
			}
			else { echo "Keine Empfänger ausgewählt!"; }
		}
		
		#Ende New Notification E-Mail
		
		#Edit-Prozeduren
		#Edit-SQL
		if(isset($_POST['submitEdit'])){
			$daten = array("email" => $_POST['email'], "institution" => $_POST['institution'], "name" => $_POST['username'], "firstname" => $_POST['firstname']);
			$sql = "UPDATE vl_notific_maildata SET email = :email, institution = :institution, name = :name, vorname = :firstname WHERE vl_notific_maildata_id = ".$_POST['vl_notific_maildata_id'].";";
			$erg = $db->prepare($sql);
			$erg->execute($daten);	
		}
		
		#Edit-Formular
		if(isset($_GET['edit_id'])){
			$sql = "SELECT * FROM vl_notific_maildata WHERE vl_notific_maildata_id = ".$_GET['edit_id'].";";
			#echo $sql;
			$erg = $db->query($sql);
			$row = $erg->fetch(PDO::FETCH_OBJ);
			echo "
			<form id='notificSubscribe' action='?notific' method='post'>
			<table>
			<tr>
				<td id='email_label'>E-Mail:	</td>
				<td><input type='text' name='email' style='width:300px;' value='".$row->email."'/> <span class='warn' id='email_warn'></span></td>
			</tr>
			<tr>
				<td id='name_label'>Vorname:</td>
				<td><input type='text' name='firstname' style='width:300px;' value='".$row->vorname."'/> <span class='warn' id='name_warn'></span></td></tr>
			
			<tr>
				<td id='name_label'>Nachname:</td>
				<td><input type='text' name='username' style='width:300px;' value='".$row->name."'/> <span class='warn' id='name_warn'></span></td></tr>
			<tr>
				<td>Institution:</td><td> <input type='text' name='institution' style='width:300px;' value='".$row->institution."'/></td>
			</tr>
			
			<tr><td></td><td> <input type='submit' name='submitEdit' value='Eintragen!' />
			<input type='hidden' name='vl_notific_maildata_id' value='".$row->vl_notific_maildata_id."'>
			</td></tr>
			</table>
	
			</form>";
		}
		
		#Ende Edit-Prozeduren
		
		#Aufbau Abonnenten-Tabelle
		echo "<form name='top_action' method='post' action='?notific' style='margin-bottom:10px;'>";
		
		#Delete-Confirmation bei Array-Uebergabe
		if(isset($_POST['deleteUser'])){
			if(isset($_POST['vl_mail_id'])){
			echo "Ausgewählte Einträge wirklich löschen?<br/>";
			
			echo "<input type='submit' name='delYes' value='Ja'> <input type='submit' name='delNo' value='Nein'><br/><br/>";
			}
			else { echo "Keine Einträge ausgewählt!<br/>"; }
			
		}
		
		echo "<input type='submit' name='newInfoMail' value='Neue Benachrichtung an ausgewählte Empfänger erstellen!'>";
		echo "<input type='submit' name='deleteUser' value='Ausgewählte Empfänger l&ouml;schen!'>";
		
		
		$sql = "SELECT * FROM vl_notific_maildata WHERE vl_journal = '".$_SESSION['repositum_user']."' ORDER BY name ASC;";
		$erg = $db->query($sql);
		
		echo "<table>";
		echo "<tr style='background-color:#bdbdbd; font-weight:bold; height:24px; '>";
			echo "<td style='width:20px; text-align:center; cursor:pointer;'><img src='images/checkmark_15px.png' alt='Alle markieren/demarkieren' title='Alle markieren/demarkieren' id='checkMark'></td>";
			echo "<td>Name, Vorname</td>";
			echo "<td>Institution</td>";
			echo "<td>E-Mail</td>";
			echo "<td></td><td></td>";
		echo "</tr>";
		
		$i=0;
		
		while ($row = $erg->fetch(PDO::FETCH_ASSOC)){
			echo "<tr class='data'>";	
			#echo $_POST['vl_mail_id'][$i];
				echo "<td style='text-align:center; '><input class='vl_maildata' type='checkbox'  name='vl_mail_id[]' value='".$row['vl_notific_maildata_id']."' ";
				if(!isset($_POST['delNo'])) {
					if(isset($_POST['vl_mail_id']) and $_POST['vl_mail_id'][$i]==$row['vl_notific_maildata_id']) { echo " checked "; $i++;}
				}
				echo "></td>";
				echo "<td>".$row['name'].", ".$row['vorname']."</td>";
				echo "<td>".$row['institution']."</td>";
				echo "<td>".$row['email']."</td>";
				echo "<td style='width:24px; text-align:center;'><a href='?notific&edit_id=".$row['vl_notific_maildata_id']."'><img src='images/edit.png' alt='Bearbeiten' title='Bearbeiten'></a></td>";
				echo "<td style='width:24px; text-align:center;'><a href='?notific&delete_id=".$row['vl_notific_maildata_id']."'><img src='images/delete.png' alt='L&ouml;schen' title='L&ouml;schen'></a></td>";	
			echo "</tr>";	
		
		}
		
		echo "</table>";	
		echo "</form>";		
        
?>        