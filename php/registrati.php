<!-- a href="/gandolfo/index.php"><img id = "logo" src="/gandolfo/images/logo.png" alt="Logo 7Wings"> </a-->
<?php
    /************************************************/
	//to do: remove in production
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	/***********************************************/
   
	require_once __DIR__ . "/util/config.php";
	
    include DIR_UTIL . "sessionUtil.php";

    include('./layout/intestazione.php');   

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
            $stmt = $con->prepare("SELECT idUtente
                FROM utente
                WHERE Email = ?;");
            $stmt->bind_param("s", $_POST['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $stmt->close();
            
            if ($result->num_rows >0) {
                echo 'E-mail già utilizzata, provare con un\'altra.';
            } else {
                $stmt = $con->prepare("INSERT INTO utente (Nome, Cognome, Email , Pass )
                    VALUES(?, ?, ?, ?);");
                $stmt->bind_param("ssss", $nome, $cognome, $email, $password1);
                if ($stmt->execute() ) {
                    echo "Benvenuto nel nostro team! Ora puoi effettuare l'accesso dalla home page";
                } else {
                    echo "Registrazione fallita!";
                }    
            }

        } else {
            echo "ATTENZIONE Le due password non corrispondono!";
        }		
	}
    include('./layout/footer.php');
    $con->close();
?>
 
