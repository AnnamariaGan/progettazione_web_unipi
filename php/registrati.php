<a href="/gandolfo/index.php"><img id = "logo" src="/gandolfo/images/logo.png" alt="Logo 7Wings"> </a>
<br>
	
<?php
	require_once __DIR__ . "/util/config.php";
	
    include DIR_UTIL . "sessionUtil.php";

	$dbHostname = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName = "wings";

	$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		exit('Failed to connect to MySQL: ' . mysqli_connect_error() );
	}

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
	$email = $_POST['email'];
    $password1 = sha1(md5(sha1($_POST['psw'])));  
    $password2 = sha1(md5(sha1($_POST['psw-repeat'])));
 
	if(isset($nome, $cognome, $email, $password1, $password2)){
        if($password1 == $password2){
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
 
