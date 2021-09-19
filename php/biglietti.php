<?php
	  /************************************************/
	//to do: remove in production
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	/***********************************************/
	
	require_once __DIR__ . "/util/config.php"; //define dir e cose
	session_start();
    include DIR_UTIL . "sessionUtil.php"; //per accedere all account tramite email

	include('./layout/intestazione.php');  // logo e barra menu
	
	$dbHostname = "localhost";  //per il db
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "wings";

	$adulti = 0;
	$bambini = 0;
	$data;
	$ora;
	$partenza = '';
	$destinazione = '';

	//connessione al db
	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	//recupero numero bambini e prenotazioni
	$queryText = "select * from prenotazioni P 
				inner join volo V on V.idVolo = P.volo
				inner join rotta R on V.Rotta = R.idRotta
				where P.id = " . $_POST['idPrenotazione'] .";";
	
	$result = $con->query($queryText);
	
	if(mysqli_num_rows($result)==0){
		echo 'Errore, qualcosa è andato storto, riprovare o contattare l\'assistenza.';
	} else {
		while ($row = $result->fetch_assoc() ) {
			$bambini = $row['bambini'];
			$adulti = $row['postiPrenotati'] - $bambini;
			$data = $row['Data'];
			$ora = $row['Ora'];
			$partenza = $row['Partenza'];
			$destinazione = $row['Destinazione'];

		}
	}

	echo '<div id="idPrenotazioneDiv" hidden>';
	echo $_POST['idPrenotazione'];
	echo '</div>';
	
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

<!DOCTYPE html>
<html lang = "it">
	<head>
		<meta charset="utf-8">
		<meta name = "author" content = "progetto">
		<meta name = "keywords" content = "sito">
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" /> 
		<!-- voli.css da aggiustare nel caso-->
		<!-- css grid , questo non ricordo a cosa si riferisce--> 
		<link href="./../css/voli.css" rel="stylesheet" type="text/css">
		<title>voli</title>
		
	</head>
	
	<body onload="firstLoadPasseggeri();">
        <!-- devo creare il form dove inserire le credenziali delle persone
            e aggiungerle nel db 

            eventualmente far pagare i bagagli aggiuntivi


            mi serve la prenotazione per aggiungere i tizi al db
        -->
		<div id = "adulti">
			Adulti: 
			<?php
				echo $adulti;
			?>
		</div>
			<?php
				if ($bambini > 0) {
					echo '<div id = "bambini">';
					echo "bambini ";
					echo $bambini;
					echo '</div>';

				}
			?>
		<div>
			<?php 
				echo $data;
				echo " ";
				echo $ora ;
				echo "  da ";
				echo $partenza;
				echo "  a ";
				echo $destinazione;

			?>
		</div>
		
		<div id="loadTicketsContainer">
			<div id="loadedTickets">
				<?php 
					loadTickets($con);
				?>
				<div id="checkedTickets" hidden>0</div>
			</div>
		</div>

		<div id="totalRequested" hidden>
			<?php
				echo ($adulti + $bambini);
			?>
		</div>

		<!-- div id="ticketList"-->
		
		
    </body>
	
	<script src="../js/ajax/bigliettiCheck.js"></script>
	<script src="../js/biglietti.js"></script>

	
	<?php
		$con->close();
	?>
</html>