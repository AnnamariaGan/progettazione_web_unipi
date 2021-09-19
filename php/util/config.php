<?php
		define ("DIR_BASE", __DIR__ . '/');
		define ("DIR_UTIL", DIR_BASE . '');
		define ("DIR_LAYOUT", DIR_BASE . 'layout/');


	function alert($msg) {
		echo '<script type="text/javascript">
			alert("'.$msg.'");
			window.location = "/gandolfo/index.php";
		</script>';
	}

?>
<?php
	//require_once __DIR__ . "/config.php";
	//session_start();
    //include DIR_UTIL . "sessionUtil.php";
    /*
    if (!isLogged()){
		    header('Location: ./../index.php');
		    exit;
    }
	*/	
?>