<?php
	//variabili di sessione
	//setSession: set $_SESSION properly
	function setSession($mail, $pass){
		$_SESSION['pass'] = $pass;
		$_SESSION['mail'] = $mail;
	}

	//isLogged: check if user has logged in and, if it is the case, returns the username
	function isLogged(){		
		if(isset($_SESSION['mail']))
			return $_SESSION['mail'];
		else
			return false;
	}
	
    /*
    TO DO: aggiungere ad inizio pagina dopo include e require
    if (!isLogged()){
		    header('Location: ./../index.php');
		    exit;
    }	
    */

?>
