<?php
	require_once __DIR__ . "/util/config.php";
    include DIR_UTIL . "sessionUtil.php";

	//recupero quello che ho inviato con POST
	$mail = $_POST['mail'];
	$password = sha1(md5(sha1($_POST['psw'])));  

	$errorMessage = login($mail, $password);
    //echo $errorMessage;
	if ( $errorMessage === null) {
		header('location: ./profilo.php');
    } else {
        alert('Email o password non presente nel database.');
		//header('location: ./../index.php?errorMessage=' . $errorMessage );
        //header('location: /gandolfo/index.php');
        
		exit;
    }

	function login($username, $password){   
		if ($username != null && $password != null){
			$userId = authenticate($username, $password);
    		if (intval($userId) > 0){
                echo $userId;
    			session_start();
    			setSession($username, $password);
    			return null;
    		}

    	} else {
    		return 'You should insert something';
        }

    	return 'Username and password not valid.';
	}
	
	function authenticate ($username, $password){   
        $dbHostname = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "wings";

        $con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
        
        if(mysqli_connect_errno()){
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }

        if( isset($username, $password) ){
            $queryText = "select * 
                        from utente
                        where Email = '".$username."' and Pass = '".$password."';" ;
            
            $result = $con->query($queryText);
            $ret = mysqli_num_rows($result);
            $con->close();
            //echo '<script type="text/javascript"></script>' ;
            //alert($ret);
            return $ret;
        } else {
            $con->close();
            echo '<script type="text/javascript"></script>' ;
            alert("Riempi tutti i campi");
            return -1;
            //	$PHPtext = "Inserisci tutti i campi!";
        } 
        /*
        $con->close();
        $userRow = $result->fetch_assoc();
        $con->close();
        return $userRow['idUtente']; 
        */
    }
?>
