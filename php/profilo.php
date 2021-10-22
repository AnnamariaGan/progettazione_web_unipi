<?php
	/************************************************/
	//to do: remove in production
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	/***********************************************/

	session_start();
	require_once __DIR__ . "/util/config.php";
	require_once DIR_UTIL . "sessionUtil.php"; 

	if (!isLogged()){
		header('Location: ./account.php'); 
		alert('Accedi al tuo profilo');
		exit;
	}

	function prenotatiUtil(){
		$dbHostname = "localhost";  
		$dbUsername = "root";
		$dbPassword = "";
		$dbName = "wings";
		$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
		if(mysqli_connect_errno()){
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		
		$stmt = $con->prepare( "select * from volo V 
		inner join rotta R on V.Rotta = R.idRotta 
		inner join prenotazioni P on V.idvolo = P.volo
		where P.utente = ?
			AND P.`check` < P.`postiPrenotati`
		order by V.`Data` DESC, V.`Ora` DESC, P.`check` DESC;");
		$stmt->bind_param('s', $_SESSION['mail']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->get_result($result);
/*
		$queryText = "select * from volo V 
					inner join rotta R on V.Rotta = R.idRotta 
					inner join prenotazioni P on V.idvolo = P.volo
					where P.utente = '".$_SESSION['mail']."'
						AND P.`check` < P.`postiPrenotati`
					order by V.`Data` DESC, V.`Ora` DESC, P.`check` DESC;" ;
						
		$result = $con->query($queryText);
*/		
		if(mysqli_num_rows($result)==0){
			echo 'Non hai prenotato nessun volo.';
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
			echo 'Posti prenotati';
			echo '</div>';

			echo '<div class="grid-item">';
			echo 'Stato Check-in';
			echo '</div>';

			echo '</div>';
		
			while ($row = $result->fetch_assoc() ) {
				echo '<div class="grid-row" ';
				echo 'onclick="rowClick(';
				echo $row['id'];
				echo ');" id="row-';
				echo $row['id'];
				echo '">';
				

				echo '<div class="grid-item">';
				echo $row['Partenza'];
				echo '</div>';

				echo '<div class="grid-item">';
				echo $row['Destinazione'];
				echo '</div>';
			
				echo '<div class="grid-item">';
				echo $row['Ora'];
				echo '</div>';
			
				echo '<div class="grid-item">';
				echo $row['postiPrenotati'];
				echo '</div>';

				echo '<div class="grid-item">';
				if ($row['check'] == 'S') {
					echo 'check-in effettuato';
				} else {
					echo "<button>FAI CHECK-IN</button>";
				}
				echo '</div>';


				echo '</div>';
			}

			echo '</div>';
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
		<link href="/gandolfo/css/profilo.css" rel="stylesheet" type="text/css">
	
		<title>profilo</title>
	</head>
	
	<body>
		<section id = "intestazione">
			<div id ="header_wrapper" style = "text-align:center">
				<a href="./gandolfo/index.php"><img src="/gandolfo/images/logo.png" 
					alt="Logo 7Wings" max-width="auto" max-height="auto"> </a>
			</div>
			<?php
				include('./layout/intestazione.php'); 
			?>  
		</section>

        <h1>Benvenuto nella tua area personale</h1>
		<!-- sezione viaggi non serve -->
	<!--	<section id = "viaggi">
			<h2>I miei viaggi</h2>
			<?php
				//se non ci sono viaggi dire: non hai prenotato nessun viaggio.
				//torna alla homepage e prenota un volo

				//caricare dal db i viaggi di tizio loggato in una tabella
			?>
		</section>  -->
		<br>
		<hr  noshade>
		<br>
		<section id = "check">
			<h1>Effettua il check-in prima di partire.</h1>
			 
			
			<?php
				include('./checkin.php'); 
				prenotatiUtil();
			?>  
		  
        </section>
		<br>
		<hr noshade>
		<br>
		
		<section id="logoutSection"> 
			<form action='./logout.php' id='logout'>
				<button class = "butoon" type="submit" >ESCI</button>
			</form>
		</section>
		<br>
				<hr  noshade>
			<br>
        <footer id="sign_in_footer">
			<div class="legal_form">
			
				<?php
					include('./layout/footer.php');
				?>  
			</div>
		</footer>
	</body>

	<script src="../js/profilo.js"></script>	
</html>