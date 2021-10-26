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
		
		//loadTickets($nome, $cognome, $documento, $bambino, $idPrenotazione);


		echo $nome.' '.$cognome.' '.$documento.' ';
		echo md5($idPrenotazione).' ';
		if ($bambino == 1) {
			echo 'bambino';
			$stmt2 = $con->prepare( "UPDATE prenotazioni
				SET `checkChildren` = `checkChildren` + 1
				WHERE id = ?;");
			$stmt2->bind_param('i', $idPrenotazione);
			$stmt2->execute();
		} else {
			echo 'adulto';
		}

		$stmt2 = $con->prepare( "UPDATE prenotazioni
				SET `check` = `check` + 1
				WHERE id = ?;");
		$stmt2->bind_param('i', $idPrenotazione);
		$stmt2->execute();
	}

	function loadTickets($nome, $cognome, $documento, $bambino, $idPrenotazione){


		echo '<div class="grid-row"> ';
		
			echo '<div class="grid-item">';
				echo $nome.' '.$cognome;
			echo '</div>';

			echo '<div class="grid-item">';
				echo $documento;
			echo '</div>';
		
			echo '<div class="grid-item">';
				echo md5($idPrenotazione);
				if ($bambino == 1) {
					echo '<br> bambino';
				} else {
					echo '<br> adulto';
				}
			echo '</div>';
		
		echo '</div>';
	}


	
	$con->close();
?>   
