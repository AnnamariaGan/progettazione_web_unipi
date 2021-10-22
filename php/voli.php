<?php
	require_once __DIR__ . "/util/config.php"; //define dir e cose
	session_start();
    include DIR_UTIL . "sessionUtil.php"; //per accedere all account tramite email

	echo'
	<header class="bar_header">
			<div id ="header_wrapper" style = "text-align:center">
				<a href="/gandolfo/index.php"><img src="/gandolfo/images/logo.png" 
					alt="Logo 7Wings"max-width="auto" min-height="auto"> </a>
			</div>
	</header>
	';
	include('./layout/intestazione.php');  // logo e barra menu
	
	function utilityButton() {
		echo '<section id = "importo">
			<h5>TOTALE </h5>
			<h5 id="importoTotale"></h5>  
			<!-- l importomi pare che lo mostrava gia, anche moltiplicato al
			 numero di biglietti -->
		</section>

		<section id = "acquista">	
			<!-- prenota volo, fa fare il pagamento al tizio, ma deve dargli pure i voli selezionati che
			poi paga insierisce i voli nel database
			-->

			<!-- to do: disattivare il pulsante se non ci sono voli,
			 o se nessun volo e stato selezionato-->
			<form id="prenotaForm" action = "./pagamento.php"  method = "post">
				<!-- input id="andataDiv[]" type="hidden" name="andataDiv" value="" / -->
				<!-- input id="ritornoDiv[]" type="hidden" name="ritornoDiv" value="" / -->
														
				<input id="button" type="submit" disabled="true" value="PRENOTA VOLO"/>   
			</form>
		</section>';	
	}
	
	$thereareflies = false;
	$dbHostname = "localhost"; 
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "wings";
	
	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	
	$tipo_viaggio = $_POST['tipo_viaggio'];
	$partenza = $_POST['partenza'];
	$destinazione = $_POST['destinazione'];
	$dataPartenza = $_POST['data_partenza'];
	$dataRitorno = $_POST['data_ritorno'];
	$adulti = $_POST['adulti'];
	$bambini = $_POST['bambini'];

	$numero = 0;
	if (isset($bambini) ) {
		echo $bambini;
        $numero += $bambini;
		setcookie('bambini', $bambini);
    }
	if (isset($adulti) ) {
        $numero += $adulti;
    }
	setcookie('numero', $numero);
	
	echo '<div id="numero-Adulti" style="visibility: hidden;">'.$adulti.'</div>';
	echo '<div id="numero-Bambini" style="visibility: hidden;">'.$bambini.'</div>';

	function tableUtility($tipo_volo, $rowClickString, $partenza, $destinazione, $dataPartenza, $adulti) {
		if(isset($tipo_volo, $partenza, $destinazione, $dataPartenza, $adulti) ) {
			return;
		}
		$partenzaUtil = 'Partenza';
		$destinazioneUtil = 'Destinazione';
		
		if ($tipo_volo == 'RITORNO') {
			$partenzaUtil = 'Destinazione';
			$destinazioneUtil = 'Partenza';
		} else if ($tipo_volo != 'ANDATA') {
			return;
		}
		
		$stmt = $con->prepare("select * from volo V 
			inner join rotta R on V.Rotta = R.idRotta 
			where R.Partenza = ?
				and R.Destinazione = ?
				and V.Data = ?;");

		$stmt->bind_param('sss', $partenza, $destinazione, $dataPartenza);
		$stmt->execute();
		$stmt->store_result();
		$result = $stmt->get_result();

		echo '<h1>VOLI DI '.$tipo_volo.'</h1>';

		if(!$result || mysqli_num_rows($result)==0){
			echo 'Mi dispiace, ma non abbiamo trovato 
			nessun volo con queste caratteristiche';
		} else {  

			echo '<div class="grid-container">';

			echo '<div class="grid-row">';

			echo '<div class="grid-item">';
			echo 'Partenza';
			echo '</div>';

			echo '<div class="grid-item">';
			echo 'Destinazione';
			echo '</div>';

			echo '<div class="grid-item">';
			echo 'Ora partenza';
			echo '</div>';

			echo '<div class="grid-item">';
			echo 'Prezzo €';
			echo '</div>';

			echo '<div class="grid-item">';
			echo 'Posti disponibili';
			echo '</div>';

			echo '</div>';
			
			while ($row = $result->fetch_assoc() ) {

				$postiLiberi = 250 - $row["PostiOccupati"];
				if($postiLiberi < ($adulti + $bambini)){
					echo 'Mi dispiace, non ci sono altri 
					posti disponibili per questo volo';
				} else {
					$thereareflies = true;
				}

				echo '<div class="grid-row" onclick="'.$rowClickString.'(';
				echo $row['idVolo'].');" id="row-'.$row['idVolo'].'">';

				echo '<div class="grid-item">';
				echo $row[$partenzaUtil];
				echo '</div>';
			
				echo '<div class="grid-item">';
				echo $row[$destinazioneUtil];
				echo '</div>';
			
				echo '<div class="grid-item">';
				echo $row['Ora'];
				echo '</div>';
			
				echo '<div class="grid-item" id="pA-'.$row['idVolo'].'">';
				echo $row['Costo'];
				echo '</div>';
			
				echo '<div class="grid-item">';
				echo $postiLiberi;
				echo '</div>';

				echo '</div>';

			}

			echo '</div>';
		}
		return;
	}
	if ($tipo_viaggio == "a") {
		tableUtility('RITORNO', 'rowClick', $partenza, $destinazione, $dataPartenza, $adulti);
	} else if ($tipo_viaggio == "r") {
		tableUtility('RITORNO', 'rowClickAndata', $partenza, $destinazione, $dataPartenza, $adulti);
		tableUtility('RITORNO', 'rowClickRitorno', $partenza, $destinazione, $dataPartenza, $adulti);
	}

	utilityButton();
	
	$con->close();  
?>

<!DOCTYPE html>
<html lang = "it">
	<head>
		<meta charset="utf-8">
		<meta name = "author" content = "progetto">
		<meta name = "keywords" content = "sito">
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" /> 
		<link href="./../css/voli.css" rel="stylesheet" type="text/css">
		<title>voli</title>
		
		
	</head>
	
	<body>
		
        <section id = "infoPrezzi">
            <h1>
                IMPORTANTE
            </h1>
            <p>
                I prezzi si riferiscono per un biglietto per un adulto.
                Il prezzo del biglietto verrà dimezzato nel caso si tratta di bambini (da 2 a 16 anni).
            </p>

			<p>
				Ricorda: puoi portare con te solo una borsa piccola e un trolley.
				Eventuali altre valige puoi aggiurngerle al momento del Check In con 
				un sovraprezzo di €10,00 per ogni valigia o trolley.
			</p>
			<br>
				<hr  noshade>
			<br>
        </section>
		
        <footer id="sign_in_footer">
			
			<div id = "metodipagamento">
				<?php
					include('./layout/metodoPagamento.php');
				?> 
			</div>
			<br>
				<hr  noshade>
			<br>
			<div class="legal_form">
				<?php
					include('./layout/footer.php');
				?>  
			</div>
		</footer>
	</body>

	<script src="../js/voli.js"></script>	
</html>