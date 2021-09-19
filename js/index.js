
//controllo su tutti i campi del form cerca voli
function  controlloCampi() {
// Variabili associate ai campi del modulo
    let elem = document.getElementById('cerca_volo'); 
    var andata = elem.andata.value;
    var ritorno = elem.ritorno.value;
    var partenza = elem.partenza.value;
    var destinazione = elem.destinazione.value;
    var data_partenza= elem.data_partenza.value;
    var data_ritorno = elem.data_ritorno.value;
    var adulti = elem.adulti.value;
    var bambini = elem.bambini.value;
    
    if (andata == false && ritorno == false){
        alert("Seleziona il tipo di volo: andata o andata e ritorno");
        return false;
    }
    if(andata == true && ritorno == false){
        if(data_partenza == false){
        alert("Seleziona la data di partenza");
        return false;
        }
    }

    if(ritorno == true && andata == false){
        if(data_partenza == false || data_ritono == false){
        alert("Seleziona la data di partenza e la data di ritorno");
        return false;
        }
    }

    if(adulti + bambini < 1){
        alert("Inserisci il numero di persone(minimo 1 passeggero)");
        return false;
    }
    if (document.getElementById("checkin").innerHTML == "p") {
        if(!confirm("Devi essere registrato per prenotare, ma puoi continuare comunque cliccando su ok.") ){
            return false;
        }
    }
    elem.action = "./php/voli.php";
    elem.submit();

    return true;
}