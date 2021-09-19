<?php
    /************************************************ /
        //to do: remove in production
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
	/***********************************************/

	//require_once __DIR__ . "/config.php";
    session_start();
    
    session_destroy();
    header("Location: ../index.php");
    exit;   
?>