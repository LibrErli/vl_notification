<h1>Wikipage-Editor</h1>
<?php
#Loesch-Prozeduren
		if(isset($_GET['delete_id'])) { 
			$sql = "SELECT * FROM vl_wiki WHERE vl_wiki_id = ".$_GET['delete_id'].";";
			$erg = $db->query($sql); $row = $erg->fetch(PDO::FETCH_OBJ);
			echo "Wiki-Page ".$row->vl_wiki." (".$row->vl_wiki_lang.") wirklich l&ouml;schen?<br/>
				<form name='delUser' method='post' action='?page_edit' style='margin-bottom:20px;'>
				<input type='hidden' name='vl_notific_maildata_id' value='".$_GET['delete_id']."'/>
				<input type='submit' name='delYes' value='Ja'> <input type='submit' name='delNo' value='Nein'>
				</form>";
		}
		
		if(isset($_POST['delYes'])){
			if(isset($_POST['vl_notific_maildata_id'])){#Loeschen via vl_notific_maildata_id Value
				$sql = "DELETE FROM vl_wiki WHERE vl_wiki_id = ".$_POST['vl_notific_maildata_id'].";";
				$db->query($sql);
				echo "Eintrag erfolgreich gelöscht!";
			}
			else {#Loeschen via vl_mail_id-Array
				for($i=0;$i<count($_POST['vl_mail_id']);$i++){
					$sql = "DELETE FROM vl_wiki WHERE vl_wiki_id = ".$_POST['vl_mail_id'][$i].";";
					$db->query($sql);
					echo "Eintr&auml;ge erfolgreich gelöscht!";
				}
			}	
		}
		#Ende Loesch-Prozeduren
		
				
		#Edit-Prozeduren
		#Edit-SQL
		if(isset($_POST['submitEdit']) or isset($_POST['submitNew'])){
			$daten = array("vl_wiki_lang" => $_POST['vl_wiki_lang'], "vl_wiki_html" => $_POST['vl_wiki_html']);
			if(isset($_POST['submitEdit'])) {
			$sql = "UPDATE vl_wiki SET vl_wiki_lang = :vl_wiki_lang, vl_wiki_html = :vl_wiki_html WHERE vl_wiki_id = ".$_POST['vl_wiki_id'].";";
			}
			if (isset($_POST['submitNew'])) {
				$sql = "INSERT INTO vl_wiki (vl_wiki, vl_wiki_lang, vl_wiki_html, vl_wiki_journal) VALUES ('".$_POST['vl_wiki']."', :vl_wiki_lang, :vl_wiki_html, '".$_SESSION['repositum_user']."')";
			}
			#echo $sql;
			$erg = $db->prepare($sql);
			$erg->execute($daten);	
		}
		
		#Edit-Formular
		if(isset($_GET['edit_id'])){
			$sql = "SELECT * FROM vl_wiki WHERE vl_wiki_id = ".$_GET['edit_id'].";";
			#echo $sql;
			$erg = $db->query($sql);
			$row = $erg->fetch(PDO::FETCH_ASSOC);
		}
		elseif(isset($_POST['newPage'])) { $row=''; }
		
		if(isset($_GET['edit_id']) or isset($_POST['newPage'])){
			echo "
			<form id='pageEdit' action='?page_edit' method='post'>
			<table>
			<tr>
				<td id='email_label'>Sprache</td>
				<td><select name='vl_wiki_lang'>
					<option value='de'"; if(isset($row->vl_wiki_lang) and $row->vl_wiki_lang=='de'){ echo " selected"; } echo ">Deutsch</option>
					<option value='en'"; if(isset($row->vl_wiki_lang) and $row->vl_wiki_lang=='en'){ echo " selected"; } echo ">English</option>
					<option value='all'"; if(isset($row->vl_wiki_lang) and  $row->vl_wiki_lang=='all'){ echo " selected"; } echo ">Alle Sprachen</option>
					</select></td>
			</tr>";
			if(isset($_POST['newPage'])){
				echo "
				<tr>
					<td id='name_label'>Wiki-Seite:</td>
					<td><input type='text' name='vl_wiki' value='".get_field_value('vl_wiki',$_POST,$row)."'></td>
				</tr>";
			}
			echo"
			<tr>
				<td id='name_label'>Text:</td>
				<td><textarea name='vl_wiki_html' id='bodytext' style='width:800px; height:450px;'>".get_field_value('vl_wiki_html',$_POST,$row)."</textarea></td>
			</tr>

			
			<tr><td></td><td> 
			<input type='submit' name='"; if(isset($_GET['edit_id'])){ echo "submitEdit"; } else { echo "submitNew"; } echo "' value='Eintragen!' />";
			if(isset($_GET['edit_id'])){ echo "<input type='hidden' name='vl_wiki_id' value='".get_field_value('vl_wiki_id',$_POST,$row)."'>"; }
			echo "</td></tr>
			</table>
	
			</form>";
		}
		
		#Ende Edit-Prozeduren
		
		#Aufbau Wikipage-Tabelle
		echo "<form name='top_action' method='post' action='?page_edit' style='margin: 25px 0 10px;'>";
		
		#Delete-Confirmation bei Array-Uebergabe
		if(isset($_POST['deleteUser'])){
			if(isset($_POST['vl_mail_id'])){
			echo "Ausgewählte Einträge wirklich löschen?<br/>";
			
			echo "<input type='submit' name='delYes' value='Ja'> <input type='submit' name='delNo' value='Nein'><br/><br/>";
			}
			else { echo "Keine Einträge ausgewählt!<br/>"; }
			
		}
		
		#echo "<input type='submit' name='newInfoMail' value='Neue Benachrichtung an ausgewählte Empfänger erstellen!'>";
		echo "<input type='submit' name='newPage' value='Neue Seite anlegen'>";
		echo "<input type='submit' name='deleteUser' value='Ausgewählte Seiten l&ouml;schen'>";
		
		
		$sql = "SELECT * FROM vl_wiki WHERE vl_wiki_journal = '".$_SESSION['repositum_user']."' ORDER BY vl_wiki ASC;";
		$erg = $db->query($sql);
		
		echo "<table>";
		echo "<tr style='background-color:#bdbdbd; font-weight:bold; height:24px; '>";
			echo "<td style='width:20px; text-align:center; cursor:pointer;'><img src='images/checkmark_15px.png' alt='Alle markieren/demarkieren' title='Alle markieren/demarkieren' id='checkMark'></td>";
			echo "<td>Wiki-Page</td>";
			echo "<td>Sprache</td>";
			echo "<td></td><td></td>";
		echo "</tr>";
		
		$i=0;
		
		while ($row = $erg->fetch(PDO::FETCH_ASSOC)){
			echo "<tr class='data'>";	
			#echo $_POST['vl_mail_id'][$i];
				echo "<td style='text-align:center; '><input class='vl_maildata' type='checkbox'  name='vl_mail_id[]' value='".$row['vl_wiki_id']."' ";
				echo "></td>";
				echo "<td>".$row['vl_wiki']."</td>";
				echo "<td>".$row['vl_wiki_lang']."</td>";
				echo "<td style='width:24px; text-align:center;'><a href='?page_edit&edit_id=".$row['vl_wiki_id']."'><img src='images/edit.png' alt='Bearbeiten' title='Bearbeiten'></a></td>";
				echo "<td style='width:24px; text-align:center;'><a href='?page_edit&delete_id=".$row['vl_wiki_id']."'><img src='images/delete.png' alt='L&ouml;schen' title='L&ouml;schen'></a></td>";	
			echo "</tr>";	
		
		}
		
		echo "</table>";	
		echo "</form>";		
        
?>        