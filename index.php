<?php
	/************************************************/
	//to do: remove in production
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	/***********************************************/
	session_start();  
	require_once __DIR__. "/php/util/config.php";
	
	include DIR_UTIL . "sessionUtil.php"; 
?>

<!DOCTYPE html>
<html lang = "it">
	<head>
		<meta charset="utf-8">
		<meta name = "author" content = "progetto">
		<meta name = "keywords" content = "sito">
		<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" /> 
		<link href="./css/index.css" rel="stylesheet" type="text/css">
		<title>CercaVoliHomePage</title>
	</head>
	
	<body>  
		<section id = "intestazione"> 
			<div id ="header_wrapper" style = "text-align:center">
				<img src="/gandolfo/images/logo.png" alt="Logo 7Wings" width="420" height="187"> 
			</div>

			<?php
				include('./php/layout/intestazione.php');   
			?>
		</section>
		
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
					*I neonati (considerati fino a 3 anni) viaggiano gratuitamente.
					Non necessitano di biglietto aereo.
					I bambini da 3 a 16 anni (compresi) pagano mezzo biglietto.
				</p>
			</form>
		</section>
		
		<section> 
			<div class = "carosello">
				<?php
					include('./php/layout/carosello.php');
				?>
				<a href="php/layout/carosello.php"></a>
			</div>
		</section>
		
		<footer id="sign_in_footer">
			
			<div id = "metodipagamento">
				<?php
					include('./php/layout/metodoPagamento.php');
				?>
			</div>
			
			
			<div class="legal_form">
				<?php
					include('./php/layout/footer.php');
				?>
			</div>
		</footer>
		
		<script src="./js/ajax/rotta.js"></script>  
		<script src="./js/controlli.js"></script> 
		<script src="./js/index.js"></script> 
	</body>
	
</html>


<!-- da index.php vado nelle pagine previste dal menu   
	
	premendo CERCA VOLO -> controllo i campi del form e vado alla pagina voli.php
-->