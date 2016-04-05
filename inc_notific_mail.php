<?php

		$sql = "SELECT * FROM vl_notification_mails WHERE vl_journal = '".$_SESSION['repositum_user']."' ORDER BY datum DESC;";
		#echo $sql;
		$erg = $db->query($sql);
		
		echo "<table>";
		echo "<tr style='background-color:#bdbdbd; font-weight:bold; height:24px; '>";
			echo "<td style='width:20px; text-align:center; cursor:pointer;'><img src='images/checkmark_15px.png' alt='Alle markieren/demarkieren' title='Alle markieren/demarkieren' id='checkMark'></td>";
			echo "<td>E-Mail</td>";
			echo "<td></td><td></td>";
		echo "</tr>";
		
		$i=0;
		
		while ($row = $erg->fetch(PDO::FETCH_ASSOC)){
			echo "<tr class='data'>";	
			echo "<td></td>";
			echo "<td>".$row['datum']."<br/>Betreff: ".$row['subject']."<br/>".$row['mail']." </td>";
			echo "<td></td><td></td>";
			echo "</tr>";
		}
		
		echo "</table>";
?>