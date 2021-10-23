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
	echo '<a href="/gandolfo/index.php"><img id = "logo" src="/gandolfo/images/logo.png" alt="Logo 7Wings"> </a>';
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
	$checked = 0;

	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	$stmt = $con->prepare("select * from prenotazioni P 
		inner join volo V on V.idVolo = P.volo
		inner join rotta R on V.Rotta = R.idRotta
		where P.id = ?;");
	$stmt->bind_param('i', $_POST['idPrenotazione']);
	$stmt->execute();
	$stmt->store_result();
	$result = $stmt->get_result();
/*
	$queryText = "select * from prenotazioni P 
				inner join volo V on V.idVolo = P.volo
				inner join rotta R on V.Rotta = R.idRotta
				where P.id = " . $_POST['idPrenotazione'] .";";
	
	$result = $con->query($queryText);
*/
	//echo $result;
	if(!$result || mysqli_num_rows($result)==0){
		echo 'Errore, qualcosa è andato storto, riprovare o contattare l\'assistenza.';
	} else {
		while ($row = $result->fetch_assoc() ) {
			$bambini = $row['bambini'];
			$adulti = $row['postiPrenotati'] - $bambini;
			$data = $row['Data'];
			$ora = $row['Ora'];
			$partenza = $row['Partenza'];
			$destinazione = $row['Destinazione'];
			$checked = $row['check'];
			$checkedChildren = $row['checkChildren'];
		}
	}

	$stmt->close();

	echo '<div id="idPrenotazioneDiv" hidden>';
	echo $_POST['idPrenotazione'];
	echo '</div>';
	
	function loadTickets($con){
		$stmt = $con->prepare("select * from passeggero P
			where P.prenotazione = ?;");
		$stmt->bind_param('i', $_POST['idPrenotazione']);
		$stmt->execute();
		$stmt->store_result();
		$result = $stmt->get_result();
/*
		$queryText = "select * from passeggero P
					where P.prenotazione = " . $_POST['idPrenotazione'] .";";
		
		$result = $con->query($queryText);
*/		
		if($result && mysqli_num_rows($result) > 0) {
			while ($row = $result->fetch_assoc() ) {
				echo '<label>Nome:</label>';
				echo $row['Nome'];
				echo '  ';
				echo '<label>Cognome:</label>';
				echo $row['Cognome'];
				echo '  ';
				echo '<label>Documento:</label>';
				echo $row['Documento'];
				echo '  ';
				if ($row['bambino'] == 1) {
					echo 'bambino';
				} else {
					echo 'adulto';
				}
				echo '
				<br>
				';
			}
		}
		$stmt->close();
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
			/*
			echo '<input id="totalRequested" type="number" value="';
			echo ($adulti + $bambini);
			echo '" hidden>';
			*/
		?>
		<?php
			echo '<input id="adultRequested" type="number" value="';
			echo $adulti;
			echo '" hidden>';
		?>
		<?php
			echo '<input id="childrenRequested" type="number" value="';
			echo $bambini;
			echo '" hidden>';
		?>
		<?php
			echo '<input id="checkedAdults" type="number" value="';
			echo ($checked - $checkedChildren);
			echo '" hidden>';
		?> 
		<?php
			echo '<input id="checkedChildren" type="number" value="';
			echo $checkedChildren;
			echo '" hidden>';
		?> 
			

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
					/*if (document.getElementById("loadTicketsContainer") != null
					 && loadTickets != null)*/ try {
						let u = document.getElementById("loadTicketsContainer"); 
						u.appendChild(loadTickets);
					} catch(error) {
						console.log("codice 000");
					}
					const tipo = document.getElementById("tipoPasseggero-'.$i.'").value;
					if (tipo == "adulto") {
						let chkdAdults = parseInt(document.getElementById("checkedAdults").value) + 1;
						document.getElementById("checkedAdults").value = chkdAdults.toString();
					} else {
						let chkdChildren = parseInt(document.getElementById("checkedChildren").value) + 1;
						document.getElementById("checkedChildren").value = chkdChildren.toString();
					}

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

				if(document.getElementById( "passeggero-'.$i.'" ) != null ) 
		{
				// ...and take over its submit event.
				form'.$i.'.addEventListener( "submit", function ( event ) {
					event.preventDefault();

					sendData();
				} );
			}
				} );
		
		
		</script>';
		
	}
?>
	<?php
		$con->close();
	?>
</html>