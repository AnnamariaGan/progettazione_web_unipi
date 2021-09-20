 <div>
	<link href="/gandolfo/css/intestazione.css" rel="stylesheet" type="text/css">
<!--
	<header class="bar_header">
			<div id ="header_wrapper" style = "text-align:center">
				<a href="./gandolfo/index.php"><img src="/gandolfo/images/logo.png" 
					alt="Logo 7Wings" width="420" height="187"> </a>
			</div>
	</header>
-->
	<nav id="navBar">
		<ul>  
			<li><a href="/gandolfo/index.php">Home</a></li>   
			<li><a href="/gandolfo/php/profilo.php">Check-In</a></li>
			<li><a href="/gandolfo/html/info.html">Info e contatti</a></li>
			<?php
				if(isset($_SESSION['mail'])) {
					echo '<li><a href="/gandolfo/php/profilo.php"> Esci</a></li>';
				} else {
					echo '<li><a href="/gandolfo/php/account.php"> Accedi</a></li>';
				}
			?>	
		</ul>
	</nav>
</div>