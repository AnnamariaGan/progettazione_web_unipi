<?php
    $dbHostname = "localhost"; 
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "wings";

	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

    $nome = $_POST['Nome'];
    $cognome = $_POST['Cognome'];
	$documento = $_POST['Documento'];
	$bambino = 0;
	if ($_POST['tipoBambino'] == 'bambino') {
		$bambino = 1;
	}
    
	$idPrenotazione = $_POST['numeroPrenotazione'];
	
	if (isset($nome, $cognome, $documento, $bambino) ) {
		$stmt = $con->prepare(" INSERT INTO passeggero (Nome, Cognome, Documento, bambino, prenotazione)
			VALUES(?, ?, ?, ?, ?);");
		$stmt->bind_param('sssii', $nome, $cognome, $documento, $bambino, $idPrenotazione);
		$stmt->execute();

		echo $nome.' '.$cognome.' '.$documento.' ';
		if ($bambino == 1) {
			echo 'bambino';
			$stmt2 = $con->prepare( "UPDATE prenotazioni
				SET `checkChildren` = `checkChildren` + 1
				WHERE id = ?;");
			$stmt2->bind_param('i', $idPrenotazione);
			$stmt2->execute();
/*
			$query2 = "UPDATE prenotazioni
				SET `checkChildren` = `checkChildren` + 1
				WHERE id = ".$idPrenotazione.";";
			$stmt2 = $con->query($query2);
*/
		} else {
			echo 'adulto';
		}

		$stmt2 = $con->prepare( "UPDATE prenotazioni
				SET `check` = `check` + 1
				WHERE id = ?;");
		$stmt2->bind_param('i', $idPrenotazione);
		$stmt2->execute();
/*
		$query2 = "UPDATE prenotazioni
			SET `check` = `check` + 1
			WHERE id = ".$idPrenotazione.";";
		$stmt2 = $con->query($query2);
*/
	}

    function loadTickets($con){
		$stmt = $con->prepare("select * from passeggero P
			where P.prenotazione = ?;");
		$stmt->bind_param('i', $idPrenotazione);
		$stmt->execute();
		//$stmt->store_result();
		$result = $stmt->get_result();
/*
		$queryText = "select * from passeggero P
					where P.prenotazione = " . $idPrenotazione .";";
		
		$result = $con->query($queryText);
*/		
		if($result && mysqli_num_rows($result) > 0) {
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



<?php
    $con->close();
?>
