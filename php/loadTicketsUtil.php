<?php
	function loadTickets($con){
		$stmt = $con->prepare("select * from passeggero P
		where P.prenotazione = ?;");
		$stmt->bind_param('i',  $_POST['idPrenotazione']);
		$stmt->execute();
		$stmt->store_result();
		$result = $stmt->get_result();
/*		
		$queryText = "select * from passeggero P
					where P.prenotazione = " . $_POST['idPrenotazione'] .";";
		
		$result = $con->query($queryText);
*/		
		if ($result && mysqli_num_rows($result) > 0) {
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
