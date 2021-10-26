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
	
	$result = $stmt->get_result();

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
		$result = $stmt->get_result();

		echo '<div class="grid-container" id="grid-biglietti">';

			echo '<div class="grid-row">';

				echo '<div class="grid-item">';
					echo 'Nome';
				echo '</div>';

				echo '<div class="grid-item">';
					echo 'Documento';
				echo '</div>';

				echo '<div class="grid-item">';
					echo 'codice unico identificativo';
				echo '</div>';

			echo '</div>';
			
		if($result && mysqli_num_rows($result) > 0) {
			while ($row = $result->fetch_assoc() ) {
					echo '<div class="grid-row"> ';
				 
						echo '<div class="grid-item">';
							echo $row['Nome'].' '.$row['Cognome'];
						echo '</div>';

						echo '<div class="grid-item">';
							echo $row['Documento'];
						echo '</div>';
					
						echo '<div class="grid-item">';
							echo md5($row['id']);
							if ($row['bambino'] == 1) {
								echo '<br> bambino';
							} else {
								echo '<br> adulto';
							}
						echo '</div>';
					
					echo '</div>';
			}
			echo '</div>';
			echo '<hr/><br/>';
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
		<link href="./../css/biglietti.css" rel="stylesheet" type="text/css">
		<title>voli</title>
		
	</head>
	
	<body onload="firstLoadPasseggeri();">
	   
		<div>
			<?php 
				echo '<div class="grid-container">';

					echo '<div class="grid-row">';

						echo '<div class="grid-item">';
							echo 'Partenza';
						echo '</div>';

						echo '<div class="grid-item">';
							echo 'Destinazione';
						echo '</div>';

						echo '<div class="grid-item">';
							echo 'Data';
						echo '</div>';

					echo '</div>';
			
				
					
					
					echo '<div class="grid-row"> ';
				 
						echo '<div class="grid-item">';
							echo $partenza;
						echo '</div>';

						echo '<div class="grid-item">';
							echo $destinazione;
						echo '</div>';
					
						echo '<div class="grid-item">';
							echo $data;
							echo '<br>
							'.$ora;
						echo '</div>';
					
					echo '</div>';
				

				echo '</div>';
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

				const FD = new FormData( form'.$i.' );

				// Eseguito in caso di submit andato a buon fine
				
				XHR.addEventListener( "load", function(event) {


					//let loadTickets = document.createElement("div");

					// Recupera array del testo di risposta di checkindbutil
					const arrayResponse = (event.target.responseText).split(" ");

					try {
					// mostra il biglietto appena inserito
						// trova la grid
						const u = document.getElementById("grid-biglietti"); 
						// aggiungi in coda la row formattata da formatRenspose
						// in biglietti.js
						u.append(formatRenspose(arrayResponse));
					} catch(error) {
						console.log("codice 000XHR");
					}

					// aggiorna i valori di riferimento per i check-in adulti/bambini
					const tipo = document.getElementById("tipoPasseggero-'.$i.'").value;
					if (tipo == "adulto") {
						let chkdAdults = parseInt(document.getElementById("checkedAdults").value) + 1;
						document.getElementById("checkedAdults").value = chkdAdults.toString();
					} else {
						let chkdChildren = parseInt(document.getElementById("checkedChildren").value) + 1;
						document.getElementById("checkedChildren").value = chkdChildren.toString();
					}
					
					// rimuovi il form precedentemente utilizzato
					form'.$i.'.remove();
				} );
				

				// Eseguito in caso di errore del submit
				XHR.addEventListener("error", function( event ) {
					alert( "Oops! Something went wrong." );
				} );

				// Imposta la richiesta post
				XHR.open( "POST", "./checkindbutil.php" );

				// I dati inviati sono quelli forniti da utente nel rom
				XHR.send(FD);
			}

				// Accedi il form
				const form'.$i.'= document.getElementById( "passeggero-'.$i.'" );

				if(document.getElementById( "passeggero-'.$i.'" ) != null ) {
				// controlla il suo submit
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
