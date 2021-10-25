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
   
    
    $numero = 0;
    if (isset($_COOKIE['numero']) ) {
        $numero = $_COOKIE['numero'];
    }

    $bambini = 0;
    if ( isset($_COOKIE['bambini']) ) {
        $bambini = $_COOKIE['bambini'];
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
   
        $andate = $_COOKIE['andataDiv'];
        if (is_array($andate)) {
            foreach ($andate as $key => $andata) {
                $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value (?, ?, ?, ?)");
                $stmt->bind_param('iisi', $andata, $numero, $username, $bambini);
                $stmt->execute();
/*
                $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                        value ('".$andata."', ".$numero.", '".$username."', ".$bambini.")";
                    
                $stm = $con->query($queryText);
*/
                $stmt = $con->prepare( "UPDATE volo
                    SET PostiOccupati = PostiOccupati + ?
                    WHERE idVolo = ?;");
                $stmt->bind_param('ii', $numero, $andata);
                $stmt->execute();
/*
                $queryText = "UPDATE volo
                    SET PostiOccupati = PostiOccupati + ".$numero."
                    WHERE idVolo = ".$andata.";";
                $stm = $con->query($queryText);
*/
            }
        } else {
            //solo a fini di leggibilita`
            $andata = $andate;
            $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                value (?, ?, ?, ?)");
            $stmt->bind_param('iisi', $andata, $numero, $username, $bambini);
            $stmt->execute();
/*
            $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value ('".$andata."', ".$numero.", '".$username."', ".$bambini.")";
                
            $stm = $con->query($queryText);
*/
            $stmt = $con->prepare( "UPDATE volo
                SET PostiOccupati = PostiOccupati + ?
                WHERE idVolo = ?;");
            $stmt->bind_param('ii', $numero, $andata);
            $stm->execute();
/*
            $queryText = "UPDATE volo
                SET PostiOccupati = PostiOccupati + ".$numero."
                WHERE idVolo = ".$andata.";";
            $stm = $con->query($queryText);
*/
        }


        $ritorni = $_COOKIE['ritornoDiv'];
        if (is_array($ritorni)) {
            foreach ($ritorni as $key => $ritorno) {
                $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value (?, ?, ?, ?)");
                $stmt->bind_param('iisi', $ritorno, $numero, $username, $bambini);
                $stmt->execute();
/*
                $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                        value ('".$ritorno."', ".$numero.", '".$username."', ".$bambini.")";
                    
                $stm = $con->query($queryText);
*/
                $stmt = $con->prepare( "UPDATE volo
                SET PostiOccupati = PostiOccupati + ?
                WHERE idVolo = ?;");
                $stmt->bind_param('ii', $numero, $ritorno);
                $stmt->execute();
/*                
                $queryText = "UPDATE volo
                    SET PostiOccupati = PostiOccupati + ".$numero."
                    WHERE idVolo = ".$ritorno.";";
                $stm = $con->query($queryText);
*/
            }
        } else {
            //solo a fini di leggibilita`
            $ritorno = $ritorni;
            
            $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                value (?, ?, ?, ?)");
            $stmt->bind_param('iisi', $ritorno, $numero, $username, $bambini);
            $stmt->execute();
/*
            $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value ('".$ritorno."', ".$numero.", '".$username."', ".$bambini.")";
                
            $stm = $con->query($queryText);
*/
            $stmt = $con->prepare( "UPDATE volo
            SET PostiOccupati = PostiOccupati + ?
            WHERE idVolo = ?;");
            $stmt->bind_param('ii', $numero, $ritorno);
            $stm->execute();
/*                
            $queryText = "UPDATE volo
                SET PostiOccupati = PostiOccupati + ".$numero."
                WHERE idVolo = ".$ritorno.";";
            $stm = $con->query($queryText);
*/
        }
    
        /*
        $queryText = '';
        if (is_array($andate)) {
            for ($i = 0; $i < count($andate); $i++) {
                $andata = $andate[$i];
               
                $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value ('".$andata."', ".$numero.", '".$username."', ".$bambini.")";
                
                $stm = $con->query($queryText);

                $queryText = "UPDATE volo
                    SET PostiOccupati = PostiOccupati + 1
                    WHERE idVolo = ";
                $stm = $con->query($queryText);
            }
        
        } else {
            
            $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value ('".$andate."', ".$numero.", '".$username."', ".$bambini.")";
            
            $stm = $con->query($queryText);
         
        }

    if (isset($_COOKIE['ritornoDiv']) ){
        $ritorni = $_COOKIE['ritornoDiv'];
        if (is_array($ritorni)) {
            for ($i = 0; $i < count($andate); $i++) {
                $ritorno = $ritorni[$i];
        
                $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value ('".$ritorno."', ".$numero.", '".$username."', ".$bambini.")";
                
                $stm = $con->query($queryText);
            }

        } else {
            $queryText = "INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                    value ('".$ritorni."', ".$numero.", '".$username."', ".$bambini.")";
            
            $stm = $con->query($queryText);
           
        }
        //$stmt = $con->query($queryText);
    }    */

    $con->close();
    unset($_COOKIE['andataDiv']);
    unset($_COOKIE['ritornoDiv']);
    unset($_COOKIE['numero']);
   
    header('location: /gandolfo/index.php');
?>
