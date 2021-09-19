<?php
	/************************************************/
	//to do: remove in production
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	/***********************************************/
	session_start();  //crea una sessione o riprende quella corrente in base ad un identificatore passato
					// tramite richiesta GET o POST
	require_once __DIR__. "/php/util/config.php"; //includi il file se non e gia incluso
	
	include DIR_UTIL . "sessionUtil.php"; 

	//la connessione deve essere aperta e poi subito dopo chiusa,
	//questo in ogni funzione ajax.
/*	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbName = "wings";   //questi sono pero settati anche dbConfig.php,
						// nel caso includere quel file. (php/util)

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbName);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully";  //da togliere prima di consegnare
*/
	//echo isLogged();
?>

<!DOCTYPE html>
<html lang = "it">
	<head>
		<meta charset="utf-8">
		<meta name = "author" content = "progetto">
		<meta name = "keywords" content = "sito">
		<!-- TO DO: creare un file css  index.css e inserirlo se necessatio-->
		<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" /> 
		<title>CercaVoliHomePage</title>
	</head>
	
	<body>  
		
		<!-- intestazione = {logo, barra menu} -->
		<section id = "intestazione"> 
			<?php
				include('./php/layout/intestazione.php');   //il suo css scazza 
			?>
		</section>
		
		<!--form cerca voli -->
		<section id = "searchVolo">
		
			<form id = "cerca_volo" method="post" > <!-- centrare questa sezione -->
				<h2> <img src="images/aereo_stilizzato.jpg" alt="aereo" style="width:8%;"> VOLI</h2> 
			
				<input type="radio"  id = "andata" name="tipo_viaggio" value="a" onChange = "onChangeAndata()">
				<label for="andata">Solo andata</label>

				<input type="radio" id = "ritorno" name="tipo_viaggio" value="r" onChange = "onChangeAndata()">
				<label for="ritorno">Andata e ritorno</label><br>
				
				<i class='fas fa-plane-departure'></i>
				<label for="partenza">Partenza:</label>
				 
				<input type="text" id="partenza" name="partenza" list = "partenze" onChange="reloadDestinazioni()"/>
					<datalist id='partenze'></datalist>
				<div id = "result"></div>

				<i class='fas fa-plane-arrival'></i>
				<label for="destinazione">Destinazione:</label>
				<input type="text" id="destinazione" list="destinazioni" name="destinazione"><br>
					<datalist id='destinazioni'></datalist>

				<!--<i style='font-size:24px' class='fas'>&#xf073;</i>  -->
				<label for="data_partenza">Data di partenza:</label>
				<input type="date" id="data_partenza" name="data_partenza" onChange="onChangePartenza()"/>

				<!--<i style='font-size:24px' class='fas'>&#xf073;</i> -->
				<label for="data_ritorno">Data di ritorno:</label>
				<input type="date" id="data_ritorno" name="data_ritorno" onChange="onChangeRitorno()"/><br>

				<label for="passeggeri">Adulti(da 17 anni)*:</label>
				<input type="number" id="adulti" name="adulti" min="1" max="30"><br>

				<label for="bambini">Bambini(da 3 a 16 anni)*:</label>
				<input type="number" id="bambini" name="bambini" min="0" max="30"><br>
				
				<?php
					if (isset($_SESSION['mail']) ) {
						echo '<div id="checkin" style = "display: none">q</div>';
					} else {
						echo '<div id="checkin" style = "display: none">p</div>';
					}
				?>

				<input type="submit" value="Cerca volo" onclick= "controlloCampi();"/> 
				<p>
					*I neonati da 0 a 23 mesi viaggiano gratuitamente.
					I bambini da 2 a 16 anni pagano mezzo biglietto.
				</p>
			</form>
		</section>
		
		<section>  <!-- Fatti ispirare con le foto delle regioni-->
			<div class = "carosello">
				<?php
					include('./php/layout/carosello.php');
				?>
				<a href="php/layout/carosello.php"></a>
			</div>
		</section>
		
		<footer id="sign_in_footer">
			<!-- metodi di pagamento e seguici sui social -->
			<div id = "metodipagamento">
				<?php
					include('./php/layout/metodoPagamento.php');
				?>
			</div>
			
			<!--termini e condizioni ecc -->
			<div class="legal_form">
				<?php
					include('./php/layout/footer.php');
				?>
			</div>
		</footer>
		<!-- non spostare gli script-->
		<script src="./js/ajax/rotta.js"></script>   <!-- qui vengono caricate tutte le rotte -->
		<script src="./js/controlli.js"></script> <!-- controllo sulle date -->
		<script src="./js/index.js"></script> <!-- controllo sui campi inseriti dall utente -->
	</body>
	
</html>


<!-- da index.php vado nelle pagine previste dal menu   
	
	premendo CERCA VOLO -> controllo i campi del form e vado alla pagina voli.php
-->