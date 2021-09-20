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
?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset = "utf-8">
		<meta name = "author" content = "Annamaria Gandolfo">
		<meta name = "keywords" content = "Manuale utente">
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" /> 
		 <link rel = "stylesheet" href = "/gandolfo/css/pagamento.css">
         <script src="./js/ajax/pagamento.js"></script>  <!-- rivedi percorso: non funziona -->
		<title> 7 wings pagamento</title>
	</head>
	<body>
        <a href="/gandolfo/index.php"><img src="/gandolfo/images/logo.png" alt="Logo 7Wings" width="400" height="150"> </a>
	
		<section id = "pagamento">
                <form id = "pay">
                    <label for="name">Nome e Cognome</label>
                    <input id="name" maxlength="40" type="text"></br>

                    <label for="cardnumber">Numero carta di credito</label>
                    <input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric"></br>

                    <label for="expirationdate">Scadenza (mm/yy)</label>
                    <input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric"></br>

                    <label for="securitycode">CVV</label>
                     <input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric"></br>
                </form>
               
                <div class="panel-footer">
                    <!-- aggiungere al bottone pagamento un alert: PAGAMENTO EFFETTUATO CON SUCCESSO , valige prenotate-->
                    <button class="btn btn-warning btn-lg btn-block" >Paga adesso</button>
                    <?php

                    ?>
                    
                </div>
        </section>

        <footer>
            <?php
				include('./layout/footer.php');
			?>
        </footer>
    </body>
</html>