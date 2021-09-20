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

    
    if (!isLogged()){
		    header('Location: ./account.php'); 
            alert('Accedi al tuo profilo per effettuare la prenotazione');
		    exit;
    }
  
    if (isset($_POST['andataDiv']) ) {
        setcookie('andataDiv', $_POST['andataDiv']);
    }

    if (isset($_POST['ritornoDiv']) ) {
        setcookie('ritornoDiv', $_POST['ritornoDiv']);
    }
?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset = "utf-8">
		<meta name = "author" content = "Annamaria Gandolfo">
		<meta name = "keywords" content = "Manuale utente">
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" /> 
	
        <link href="/gandolfo/css/voli.css" rel="stylesheet" type="text/css">

        <script src="/gandolfo/js/pagamento.js"></script> 

		<title> 7 wings pagamento</title>
	</head>
	<body>
    <a href="/gandolfo/index.php"><img src="/gandolfo/images/logo.png" alt="Logo 7Wings" max-width="auto" max-height="auto"> </a>
	
		<section id = "pagamento">
            <img id = "pay" class="img-responsive cc-img" src="/gandolfo/images/logopay.png" width="300" height="100">
            <h3 class="text-center">Paga con conto PayPal</h3>
            <form id = "pagaPaypal" action = "./prenotazione.php" method = "post" onSubmit= "pagaPaypal();">
                <p>Clicca qui se vuoi pagare con PayPal</p>
                <button onclick ="pagaPaypal()">PAY PAL</button>
            </form>

            <br>
            <br>
		        <hr  noshade>
		    <br>

            <form id = "pay" action="./prenotazione.php" method = "post" onSubmit="paga();">
            <h3 class="text-center">Paga con carta di credito</h3>
                <label for="name">Nome e Cognome</label>
                <input id="name" maxlength="40" type="text"></br>

                <label for="cardnumber">Numero carta di credito</label>
                <input id="cardnumber" type="text" pattern="[0-9]{8}" inputmode="numeric"></br>

                <label for="expirationdate">Scadenza (mm/yy)</label>    <!-- problemi con la data -->
                <input id="expirationdate" type="text" pattern="[0-9]{2}[/][0-9]{2}" inputmode="numeric"></br>

                <label for="securitycode">CVV</label>
                <input id="securitycode" type="password" pattern="[0-9]*" inputmode="numeric"></br>
                <br>
                <input type="submit" value="Paga adesso">
            </form>
        </section>

        <section>
            <br>
                <hr  noshade>
            <br>
            <h2>IMPORTANTE</h2>
            <p> Ricordati di effettuare il Check 2 gioni prima del viaggio.  </p>
            <h3>Cliccando su paga adesso accetti i nostri termini e condizioni.</h3>
        </section>
        
        <footer>
        <br>
		    <hr  noshade>
		<br>
            <?php
				include('./layout/footer.php');
			?>
        </footer>
    </body>
</html>