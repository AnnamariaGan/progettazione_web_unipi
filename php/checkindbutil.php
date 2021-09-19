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

    //recupero quello che ho scirtto
    $nome = $_POST['Nome'];
    $cognome = $_POST['Cognome'];
	$documento = $_POST['Documento'];
    $bambino = $_POST['tipoBambino'];

	if (isset($nome, $cognome, $documento, $bambino) ) {
        //query di insert
        $queryText = " INSERT INTO passeggero (Nome, Cognome, Documento, bambino)
                VALUES('".$nome."', '".$cognome."', '".$documento."', '".$bambino."');";
        
        $stmt = $con->query($queryText);   
	}

    //include('./loadTicketsUtil.php');
    function loadTickets($con){
		//recupero i biglietti gia` cheked in
		$queryText = "select * from passeggero P
					where P.prenotazione = " . $_POST['idPrenotazione'] .";";
		
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
?>   

<div id="loadedTickets">
    <?php 
        loadTickets($con);
    ?>
</div>

<?php
    $con->close();
?>
