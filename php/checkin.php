
<?php
	
	//	echo '<h3>"I miei viaggi"</h3>';

		$dbHostname = "localhost";
		$dbUsername = "root";
		$dbPassword = "";
		$dbName = "wings";

		$con = mysqli_connect($dbHostname, $dbUsername, $dbPassword, $dbName);
		if(mysqli_connect_errno()){
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$utente = $_SESSION['mail'];
		$queryText = "select * from prenotazioni P 
					inner join volo V on V.idVolo = P.volo
					inner join rotta R on V.Rotta = R.idRotta
					where P.utente = '$utente' 
						and P.check = 'false';" ;
			
		$result = $con->query($queryText);
		
		echo '<h1>I TUOI VOLI PRENOTATI</h1>';

			if(mysqli_num_rows($result)==0){//!$result){  //nessun risultato
				echo 'Mi dispiace, ma non hai ancora prenotato nessun volo';
			} else {  //creo tabella
				echo '<div id="voliDiv" style="visibility: hidden;"></div>';

				echo '<div class="grid-container">';

				echo '<div class="grid-row">';

				echo '<div class="grid-item">';
				echo 'rotta';
				echo '</div>';

				echo '<div class="grid-item">';
				echo 'Partenza';
				echo '</div>';

				echo '<div class="grid-item">';
				echo 'Destinazione';
				echo '</div>';

				echo '<div class="grid-item">';
				echo 'Data';
				echo '</div>';

				echo '<div class="grid-item">';
				echo 'Ora';
				echo '</div>';

				echo '<div class="grid-item">';
				echo 'Posti prenotati';
				echo '</div>';
				
				echo '</div>';
				//popolo tabella con i risultati
				while ($row = $result->fetch_assoc() ) {
					//da aggiustare
					echo '<div class="grid-row" onclick="rowClick(';
					echo $row['idVolo'].');" id="row-'.$row['idVolo'].'">';

					echo '<div class="grid-item">';
					echo $row['Partenza'];
					echo '</div>';
				
					echo '<div class="grid-item">';
					echo $row['Destinazione'];
					echo '</div>';
				
					echo '<div class="grid-item">';
					echo $row['Data'];
					echo '</div>';
				
					echo '<div class="grid-item" id="pA-'.$row['idVolo'].'">';
					echo $row['Ora'];
					echo '</div>';
				
					echo '<div class="grid-item">';
					echo $postiLiberi;
					echo '</div>';

					echo '</div>';
				}

				echo '</div>';
			}
		//carico dal db i voli per check in
		// form con ub tot di persone che ci metto nome cogno documento e numero di bagagli in piu
		// php che vede quanti bagagli > 0 ci sono e me li fa pagare alla fine-

		/*
		caso d uso 

		seleziono dalla tabello il volo per cui fare il check in 
		inserisco nel form nome e cognome e carta d identia 
		inserisco numero di bagagli in piu.
		

		se num bagagli > 0 
		allora pago e check in fatto

		altrimenti check in fatto
		*/
 

?>
       
        
		
        