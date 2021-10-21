<?php
	function loadTickets($con){
		$stmt = $con->prepare("select * from passeggero P
		where P.prenotazione = ?;");
		$stmt->bind_param('i',  $_POST['idPrenotazione']);
		$result = $stmt->execute();
/*		
		$queryText = "select * from passeggero P
					where P.prenotazione = " . $_POST['idPrenotazione'] .";";
		
		$result = $con->query($queryText);
*/		
		if(mysqli_num_rows($result) > 0) {
			while ($row = $result->fetch_assoc() ) {
				echo $row['Nome'];
				echo '  ';
				echo $row['Cognome'];
				echo '  ';
				echo $row['Documento'];
				echo '  ';
				echo $row['Bambino'];
				echo '
				';
			}
		}
	}
	
	
?>
