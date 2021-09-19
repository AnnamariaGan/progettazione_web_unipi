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

    $dbHostname = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "wings";

    $con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
    if(mysqli_connect_errno()){
        exit('Failed to connect to MySQL: ' . mysqli_connect_error() );
    }

    $username = $_SESSION['mail'];
    //echo $username;
    
    $numero = 0;
    if (isset($_COOKIE['numero']) ) {
        $numero = $_COOKIE['numero'];
    }
    /*echo 'numero: ';
    if (isset($_SESSION['adulti']) ) {
        $numero += $_SESSION['adulti'];
    }

    if ( isset($_POST['bambini']) ) {
        $numero += $_SESSION['bambini'];
    }

    echo $numero . '\n';
    */
    if (isset($_COOKIE['andataDiv']) ){
        $andate = $_COOKIE['andataDiv'];
       
        $queryText = '';
        if (is_array($andate)) {
            for ($i = 0; $i < count($andate); $i++) {
                $andata = $andate[$i];
               
                $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente)
                    value ('".$andata."', ".$numero.", '".$username."')";
                
                $stm = $con->query($queryText);
                
            }
        } else {
            
            $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente)
                    value ('".$andate."', ".$numero.", '".$username."')";
            
            $stm = $con->query($queryText);
         
        }
        //$stmt = $con->query($queryText);
    }
    
    if (isset($_COOKIE['ritornoDiv']) ){
        $ritorni = $_COOKIE['ritornoDiv'];
        if (is_array($ritorni)) {
            for ($i = 0; $i < count($andate); $i++) {
                $ritorno = $ritorni[$i];
        
                $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente)
                    value ('".$ritorno."', ".$numero.", '".$username."')";
                
                $stm = $con->query($queryText);
            }

        } else {
            $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente)
                    value ('".$ritorni."', ".$numero.", '".$username."')";
            
            $stm = $con->query($queryText);
           
        }
        //$stmt = $con->query($queryText);
    }    

   /*
    if ($errorMessage === null) {
        echo "<script>
        alert('Pagamento effettuato con successo!');
        </script>";
        //header('location: ./profilo.php');
    } else {
        alert('Qualcosa è andato storto. Ci dispiace, si prega di riprovare.');
        //header('location: ./../index.php?errorMessage=' . $errorMessage );
        //header('location: /gandolfo/index.php');
        
        exit;
    }*/
    $con->close();
    unset($_COOKIE['andataDiv']);
    unset($_COOKIE['ritornoDiv']);
    unset($_COOKIE['numero']);
    /*echo "<script>
    alert('Pagamento effettuato con successo!');
    </script>";*/
    header('location: /gandolfo/index.php');
?>        