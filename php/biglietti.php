<?php
	  /************************************************/
	//to do: remove in production
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	/***********************************************/
	
	require_once __DIR__ . "/util/config.php"; 
	session_start();
    include DIR_UTIL . "sessionUtil.php";
	include('./layout/intestazione.php'); 
	
	$dbHostname = "localhost"; 
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "wings";

	$adulti = 0;
	$bambini = 0;
	$data;
	$ora;
	$partenza = '';
	$destinazione = '';

	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}

	$queryText = "select * from prenotazioni P 
				inner join volo V on V.idVolo = P.volo
				inner join rotta R on V.Rotta = R.idRotta
				where P.id = " . $_POST['idPrenotazione'] .";";
	echo $queryText;
	$result = $con->query($queryText);
	//echo $result;
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
	
	function loadTickets($con){
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
				if ($row['bambino'] == 1) {
					echo 'bambino';
				} else {
					echo 'adulto';
				}
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
			</div>
		</div>


		
		<?php
			echo '<input id="totalRequested" type="number" value="';
			echo ($adulti + $bambini);
			echo '" hidden>';
		?>
	
		<input id="checkedTickets" type="number" value='0' hidden>
			

		<!-- div id="ticketList"-->
		
		
    </body>
	
	<script src="../js/ajax/bigliettiCheck.js"></script>
	<script src="../js/biglietti.js"></script>

	
<?php 
	$tot = $adulti + $bambini;
	for ($i = 0; $i< $tot; $i++) {
		
		echo '
		<script>
		window.addEventListener( "load", function () {
		function sendData() {
			const XHR = new XMLHttpRequest();

			// Bind the FormData object and the form element
			const FD = new FormData( form'.$i.' );

			// Define what happens on successful data submission
			XHR.addEventListener( "load", function(event) {

				form'.$i.'.remove();

				let loadTickets = document.createElement("div");
				let txt = document.createTextNode(event.target.responseText);
				loadTickets.appendChild(txt);
				document.getElementById( "loadTicketsContainer").appendChild(loadTickets);
			} );

			// Define what happens in case of error
			XHR.addEventListener( "error", function( event ) {
			alert( "Oops! Something went wrong." );
			} );

			// Set up our request
			XHR.open( "POST", "./checkindbutil.php" );

			// The data sent is what the user provided in the form
			XHR.send( FD );
		}

		// Access the form element...
		const form'.$i.'= document.getElementById( "passeggero-'.$i.'" );

		// ...and take over its submit event.
		form'.$i.'.addEventListener( "submit", function ( event ) {
			event.preventDefault();

			sendData();
		} );
		} );
		</script>';
		
	}
?>
	<?php
		$con->close();
	?>
</html>