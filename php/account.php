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

//	session_start();
//	require_once __DIR__. "./config.php"; 
	
//	include DIR_UTIL . "sessionUtil.php"; 
//	if ( isLogged() ){
//		header( 'Location: ./php/homeLatest.php');  //ultima pagina lasciata
//		exit;
//	}
//	echo __DIR__;
?>

<!DOCTYPE html>
<html lang = "it">
	<head>
		<meta charset="utf-8">
		<meta name = "author" content = "progetto">
		<meta name = "keywords" content = "sito">
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" /> 
		<link href="/gandolfo/css/account.css" rel="stylesheet" type="text/css">
		<script src="/gandolfo/js/valida.js"></script>
		<title>account</title>
	</head>
	
	<body>
		
		<section id = "intestazione">
		<div id ="header_wrapper" style = "text-align:center">
				<img src="/gandolfo/images/logo.png" alt="Logo 7Wings" max-width="auto" max-height="auto"> 
			</div>
			<?php
				include("./layout/intestazione.php"); 
			?>  
		</section>

		
		<br>
		<hr  noshade>
		<br>
		<section id = "accedi">
			<h1>ACCEDI</h1>
			
			<form name = "profilo" id="formAccedi" action="./login.php" method = "post" >
			<!--onsubmit="acceditUtil('pswA'); return false;"-->
				<div>
					<label for="mail"><b>Email</b></label>
   					<input type="text" id="mailA" placeholder="Email" name="mail">
				</div>
    			<div>
					<label for="psw"><b>Password</b></label>
   					<input id = "pswA" type="password" placeholder="Password" name="psw" required>
				</div>
				<!--div>
					<input type="radio" id="ricordami" name="Ricordami" value="true" checked >
					<label for = "ricordami">Resta collegato</label>
				</div-->
				<div>
					<!--cliccando su accedi si cambia pagina. dobbiamo andare a profilo.php -->
     				<button type="submit">Accedi</button>  
				</div>
				<div>
				<!--	<span class="psw">Hai dimenticato la <a href="#">password?</a></span> -->
					<!-- inserire pop up per cambiare la password, oppure non lo fare proprio-->
				</div>
			</form>
		</section>
		<br>
		<hr noshade>
		<br>
        <section id = "registrati">
			<h1>REGISTRATI</h1>
			
            <form name = "registrati" id="formRegistrati"  method = "post"  onChange="onChangeMail();" action="./registrati.php">
			<!-- onsubmit="registratiUtil(this,'psw', 'psw-repeat');"-->
				<div>
					<label for="	nome"><b>Nome</b></label>
					<input type="text" placeholder="Nome" name="nome" id="nome" >
				</div>
				<div>	
					<label for="cognome"><b>Cognome</b></label>
					<input type="text" placeholder="Cognome" name="cognome" id="cognome" required>
				</div>
				<div>
					<label for="email"><b>Email</b></label>
					<input type="text" placeholder="Enter Email" name="email" id="email" >
				</div>
				<div>
					<label for="psw"><b>Password</b></label>
					<input type="password" placeholder="Enter Password" name="psw" id="psw" required>
				</div>
				<div>
					<label for="psw-repeat"><b>Repeat Password</b></label>
					<input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
				</div>

				<div>
     				<button type="submit">Registrati</button>
				</div>
            </form>
        </section>
		<br>
		<hr  noshade>
		<br>
		<footer id="sign_in_footer">
			
			<div class="legal_form">
				<?php
					include("./layout/footer.php");
				?>  
			</div>
		</footer>
		 
	</body>

</html>