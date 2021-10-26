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
   
    $andate = $_COOKIE['andataDiv'];
    if (is_array($andate)) {
        foreach ($andate as $key => $andata) {
            $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                value (?, ?, ?, ?)");
            $stmt->bind_param('iisi', $andata, $numero, $username, $bambini);
            $stmt->execute();
            $stmt = $con->prepare( "UPDATE volo
                SET PostiOccupati = PostiOccupati + ?
                WHERE idVolo = ?;");
            $stmt->bind_param('ii', $numero, $andata);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        $andata = $andate;
        $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
            value (?, ?, ?, ?)");
        $stmt->bind_param('iisi', $andata, $numero, $username, $bambini);
        $stmt->execute();
        $stmt->close();

        $stmt = $con->prepare( "UPDATE volo
            SET PostiOccupati = PostiOccupati + ?
            WHERE idVolo = ?;");
        $stmt->bind_param('ii', $numero, $andata);
        $stm->execute();
    }


    $ritorni = $_COOKIE['ritornoDiv'];
    if (is_array($ritorni)) {
        foreach ($ritorni as $key => $ritorno) {
            $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
                value (?, ?, ?, ?)");
            $stmt->bind_param('iisi', $ritorno, $numero, $username, $bambini);
            $stmt->execute();
            $stmt->close();

            $stmt = $con->prepare( "UPDATE volo
            SET PostiOccupati = PostiOccupati + ?
            WHERE idVolo = ?;");
            $stmt->bind_param('ii', $numero, $ritorno);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        $ritorno = $ritorni;
        
        $stmt = $con->prepare("INSERT INTO prenotazioni(volo, postiPrenotati, utente, bambini)
            value (?, ?, ?, ?)");
        $stmt->bind_param('iisi', $ritorno, $numero, $username, $bambini);
        $stmt->execute();
        $stmt->close();

        $stmt = $con->prepare( "UPDATE volo
            SET PostiOccupati = PostiOccupati + ?
            WHERE idVolo = ?;");
        $stmt->bind_param('ii', $numero, $ritorno);
        $stm->execute();
    }

    
    $con->close();
    unset($_COOKIE['andataDiv']);
    unset($_COOKIE['ritornoDiv']);
    unset($_COOKIE['numero']);
   
    header('location: /gandolfo/index.php');
?>
