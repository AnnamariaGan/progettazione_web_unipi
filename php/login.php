<?php
	require_once __DIR__ . "/util/config.php";
    include DIR_UTIL . "sessionUtil.php";

    /************************************************/
	//to do: remove in production
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);
	/***********************************************/

	$mail = $_POST['mail'];
	$password = sha1(md5(sha1($_POST['psw'])));//$_POST['psw'];  
    
	$errorMessage = login($mail, $password);
   
	if (!isset($errorMessage) ) {
		header('location: ./profilo.php');
    } else {
        alert('Email o password non presente nel database.');
        echo $errorMessage;
		//exit;
    }

	function login($username, $password){   
		if (isset($username, $password) ) {
			$users = authenticate($username, $password);
            //echo $users;
            //alert($users);
    		if (/*intval*/($users) > 0){
                //echo $users;
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

        

        if (isset($username, $password) ) {
            $con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
        
            if (mysqli_connect_errno() ) {
                exit('Failed to connect to MySQL: ' . mysqli_connect_error() );
            }

            $stmt = $con->prepare("select idUtente
                from utente
                where Email = ? and Pass = ?;");
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            //$stmt->store_result();
            $result = $stmt->get_result();

            //echo $stmt->num_rows;
    /*        
            $queryText = "select * 
                        from utente
                        where Email = '".$username."' and Pass = '".$password."';" ;
            
            $result = $con->query($queryText);
    */
            $numUtenti = mysqli_num_rows($result);
            $con->close();
            //alert($ret);
            return $numUtenti;
        } else {
            echo '<script type="text/javascript"></script>' ;
            alert("Riempi tutti i campi");
            return -1;
        } 
    }
?>
