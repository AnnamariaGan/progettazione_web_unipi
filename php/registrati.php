<?php
	require_once __DIR__ . "/util/config.php";
	//qui non dovrebbe servire la sessione!
	//session_start();
    include DIR_UTIL . "sessionUtil.php";

	$dbHostname = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "wings";

	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error() );
	}

	//recupero quello che ho scirtto
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
	$email = $_POST['email'];
    $password1 = sha1(md5(sha1($_POST['psw'])));  
    $password2 = sha1(md5(sha1($_POST['psw-repeat'])));
 
	if(isset($nome, $cognome, $email, $password1, $password2)){
        if($password1 == $password2){
            //query di insert
            $queryText = " INSERT INTO utente (Nome, Cognome, Email , Pass )
                       VALUES('".$nome."', '".$cognome."', '".$email."', '".$password1."');";
              
            $stmt = $con->query($queryText);
               
            echo "Benvenuto nel nostro team! Ora puoi effettuare l'accesso dalla home page";
        }else{
            echo "ATTENZIONE Le due password non corrispondono!";
        }			
	}

    $con->close();
?>

<!DOCTYPE html>
<html lang = "it">
	<head>
		<meta charset="utf-8">
		<meta name = "author" content = "progetto">
		<meta name = "keywords" content = "sito">
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" /> 
		<!-- inserire il css account.css di account se necessario.
		 ogni sottocodice ha il suo css ma non lo rpende in questo caso-->
	<!--	<script src="/gandolfo/js/registrati.js"></script> -->
		<title>registrati</title>
	</head>
	
	<body>
        <a href="/gandolfo/index.php"><img src="/gandolfo/images/logo.png" 
             alt="Logo 7Wings" width="400" height="150"></a> 
	
    
    </body>

</html>