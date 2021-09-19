<?php
	function setSession($mail){
		$_SESSION['mail'] = $mail;
	}

	function isLogged(){
		if(isset($_SESSION['mail']))
			return $_SESSION['mail'];
		else
			return false;
	}
	
?>