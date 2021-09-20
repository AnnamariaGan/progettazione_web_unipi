function insertPasseggero(num, tipoBambino){   
    let newForm = document.createElement("form");
    newForm.setAttribute("method", "post");
    newForm.setAttribute("id", "passeggero-".concat(num));

    //rimuovi
    newForm.setAttribute("action", "./checkindbutil.php");

    let nome = document.createElement("input");
    nome.setAttribute("type", "text");
    nome.setAttribute("name", "Nome");
    nome.setAttribute("value", "");
 
    newForm.appendChild(nome);


    let cognome = document.createElement("input");
    cognome.setAttribute("type", "text");
    cognome.setAttribute("name", "Cognome");
    cognome.setAttribute("value", "");

    newForm.appendChild(cognome);
  

    let documento = document.createElement("input");
    documento.setAttribute("type", "text");
    documento.setAttribute("name", "Documento");
    documento.setAttribute("value", "");
    documento.setAttribute("pattern", "[A-Za-z0-9]{9}")

    newForm.appendChild(documento);


    let tipoBambinoDiv = document.createElement("input");
    tipoBambinoDiv.setAttribute("type", "text");
    tipoBambinoDiv.setAttribute("name", "tipoBambino");
    tipoBambinoDiv.setAttribute("readonly", true);
    
    if (tipoBambino != "bambino") {
        tipoBambino = "adulto";
    }
    tipoBambinoDiv.setAttribute("value", tipoBambino);

    newForm.appendChild(tipoBambinoDiv);


    let prenotazioneInput = document.createElement("input");
    prenotazioneInput.setAttribute("type", "number");
    prenotazioneInput.setAttribute("name", "numeroPrenotazione");
    prenotazioneInput.setAttribute("readonly", true);
    prenotazioneInput.hidden = true;
    const numPrenotazione = document.getElementById("idPrenotazioneDiv").innerHTML;
    prenotazioneInput.setAttribute("value", numPrenotazione);

    newForm.appendChild(prenotazioneInput);


    //aggiungo bottone submit
    let insert = document.createElement("input");
    insert.setAttribute("type", "submit");
    insert.setAttribute("value", "INSERISCI");

    newForm.appendChild(insert);

    document.body.appendChild(newForm);
} 


function firstLoadPasseggeri(){
    let tot = document.getElementById('totalRequested').value;
    //console.log(tot);
    tot -= document.getElementById('checkedTickets').value;
    //console.log(tot);
    if (tot < 0) {
        alert("An unexpected error occurred");
        console.log("totalRequested tickets are less than checkedTickets o_O .");
    }
//>>>>>>>>>>>>>>>>>>>>>TO DO CHANGE THIS
    for(let i = 0; i < tot; i++ )
        insertPasseggero(i,"adulto");
}
