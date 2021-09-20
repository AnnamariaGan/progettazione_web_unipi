<?php
	require_once __DIR__ . "/util/config.php"; //define dir e cose
	session_start();
    include DIR_UTIL . "sessionUtil.php"; //per accedere all account tramite email

	echo'
	<header class="bar_header">
			<div id ="header_wrapper" style = "text-align:center">
				<a href="./gandolfo/index.php"><img src="/gandolfo/images/logo.png" 
					alt="Logo 7Wings" width="420" height="187"> </a>
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
				<!-- input id="andataDiv" type="hidden" name="andataDiv" value="" / -->
				<!-- input id="ritornoDiv" type="hidden" name="ritornoDiv" value="" / -->
														
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
        $numero += $bambini;
    }
	if (isset($adulti) ) {
        $numero += $adulti;
    }
	setcookie('numero', $numero);

	echo '<div id="numero-Adulti" style="visibility: hidden;">'.$adulti.'</div>';
	echo '<div id="numero-Bambini" style="visibility: hidden;">'.$bambini.'</div>';

	if(isset($tipo_viaggio, $partenza, $destinazione, $dataPartenza, $adulti) && $tipo_viaggio == "a") {
			$queryText = "select * from volo V 
						inner join rotta R on V.Rotta = R.idRotta 
						where R.Partenza= '".$partenza."'
						and R.Destinazione='".$destinazione."'
						and V.Data='".$dataPartenza."';" ;
						
			$result = $con->query($queryText);
			
			echo '<h1>VOLI DI ANDATA</h1>';
			if(mysqli_num_rows($result)==0){
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
				// TO DO: refactor as function	
					$postiLiberi = 250 - $row["PostiOccupati"];
					if($postiLiberi < ($adulti + $bambini)){
						echo 'Mi dispiace, non ci sono altri 
						posti disponibili per questo volo';
					} else {
						$thereareflies = true;
					}
//TO DO: AGGIUNGI UN ELSE anche nelle altre parti <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
					echo '<div class="grid-row" onclick="rowClick(';
					echo $row['idVolo'].');" id="row-'.$row['idVolo'].'">';

					echo '<div class="grid-item">';
					echo $row['Partenza'];
					echo '</div>';
				
					echo '<div class="grid-item">';
					echo $row['Destinazione'];
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
	}
	// TO DO: refactor merging the two if	
	//andata e ritorno
	if(isset($tipo_viaggio) && $tipo_viaggio == "r"){
		if (isset( $partenza, $destinazione, $dataPartenza)  ) {
			$queryText = "select * from volo V 
						inner join rotta R on V.Rotta = R.idRotta 
						where R.Partenza= '".$partenza."'
						and R.Destinazione='".$destinazione."'
						and V.Data='".$dataPartenza."';" ;
			
			$result = $con->query($queryText);
			echo '<h1>VOLI DI ANDATA</h1>';
			if(mysqli_num_rows($result)==0){
				echo 'Mi dispiace, ma non abbiamo trovato 
				nessun volo.';
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

					echo '<div class="grid-row" onclick="rowClickAndata(';
					echo $row['idVolo'].');" id="row-'.$row['idVolo'].'">';

					echo '<div class="grid-item">';
					echo $row['Partenza'];
					echo '</div>';

					echo '<div class="grid-item">';
					echo $row['Destinazione'];
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
		}
	}
			
		if(isset($partenza, $destinazione, $dataRitorno, $tipo_viaggio)
		 && $tipo_viaggio == 'r'){
			$queryText = "select * from volo V 
						inner join rotta R on V.Rotta = R.idRotta 
						where R.Partenza= '".$destinazione."'
						and R.Destinazione='".$partenza."'
						and V.Data='".$dataRitorno."';" ;
			
			$result = $con->query($queryText);
			echo '<h1>VOLI DI RITORNO</h1>';
			if(mysqli_num_rows($result)==0){
				echo 'Mi dispiace, ma non abbiamo trovato 
				nessun volo.';
			}else{

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
					echo '<div class="grid-row" onclick="rowClickRitorno(';
						echo $row['idVolo'].');" id="row-'.$row['idVolo'].'">';

						echo '<div class="grid-item">';
						echo $row['Destinazione'];
						echo '</div>';

						echo '<div class="grid-item">';
						echo $row['Partenza'];
						echo '</div>';

						echo '<div class="grid-item">';
						echo $row['Ora'];
						echo '</div>';

						echo '<div class="grid-item" id="pR-'.$row['idVolo'].'">';
						echo $row['Costo'];
						echo '</div>';

						echo '<div class="grid-item">';
						echo $postiLiberi;
						echo '</div>';

					echo '</div>';
				}
				echo '</div>';
			}	
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
		<!-- voli.css da aggiustare nel caso-->
		<!-- css grid , questo non ricordo a cosa si riferisce--> 
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
				un sovraprezzo di €10,00 per ogni valigia o trolley per un massimo di 15 kg.
			</p>
        </section>
		
        <footer id="sign_in_footer">
			
			<div id = "metodipagamento">
				<?php
					include('./layout/metodoPagamento.php');
				?> 
			</div>
			
			<div class="legal_form">
				<?php
					include('./layout/footer.php');
				?>  
			</div>
		</footer>
	</body>

	<script src="../js/voli.js"></script>	
</html>