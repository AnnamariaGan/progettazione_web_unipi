<?php
    $dbHostname = "localhost";  //per il db
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "wings";

	//connessione al db
	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

    //recupero quello che ho scritto
    $nome = $_POST['Nome'];
    $cognome = $_POST['Cognome'];
	$documento = $_POST['Documento'];
	$bambino = 0;
	if ($_POST['tipoBambino'] == 'bambino') {
		$bambino = 1;
	}
    
	$idPrenotazione = $_POST['numeroPrenotazione'];
	
	if (isset($nome, $cognome, $documento, $bambino) ) {
        //query di insert
        $queryText = " INSERT INTO passeggero (Nome, Cognome, Documento, bambino, prenotazione)
                VALUE ('".$nome."', '".$cognome."', '".$documento."', ".$bambino.", ".$idPrenotazione.");";
        
        $stmt = $con->query($queryText);
		//echo $queryText; 
//<<<<<<<<<< TO DO:
		//echo '<div id="loadedTickets">';
		 
		echo $nome.' '.$cognome.' '.$documento.' ';
		if ($bambino == 1) {
			echo 'bambino';
			$query2 = "UPDATE prenotazioni
				SET `checkChildren` = `checkChildren` + 1
				WHERE id = ".$idPrenotazione.";";
			$stmt2 = $con->query($query2);
		} else {
			echo 'adulto';
		}


		$query2 = "UPDATE prenotazioni
			SET `check` = `check` + 1
			WHERE id = ".$idPrenotazione.";";
		$stmt2 = $con->query($query2);
	}

	/*
    //include('./loadTicketsUtil.php');
    function loadTickets($con){
		//recupero i biglietti gia` cheked in
		$queryText = "select * from passeggero P
					where P.prenotazione = " . $idPrenotazione .";";
		
		$result = $con->query($queryText);
		
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
	*/
?>   



<?php
    $con->close();
?>
