function paga(){
        // Variabili associate ai campi del modulo
        //alert("Ciup");
            //let elem = document.getElementById("pay"); 
            let scadenza = document.getElementById("expirationdate").value;
      
            var str = scadenza;
            var mese = str.substring(0,2);
            var anno = str.substring(3,5);
            console.log(mese, typeof mese);
            console.log(parseInt(mese));
            console.log(anno);
            if (parseInt(mese) > 12){
                alert("inserisci una data corretta");
                return false;
            }
            
            let yearUtil = (new Date().getFullYear() -2000);
            if(parseInt(anno) < yearUtil ){
                alert("carta scaduta");
                return false;
            }

    //alert("Pagamento effettuato con successo");
    //window.location.href = "../prenotazione.php"; 
    //return true;
}

function pagaPaypal(){
    alert("Pagamento effettuato con paypal");
}

//qua i crea il problema delle pass salvate e mi mostra un messaggio di errore e non gli alert