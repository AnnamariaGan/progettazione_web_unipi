function insertPasseggero(num, tipoBambino){   
    let newForm = document.createElement("form");
    newForm.setAttribute("method", "post");
    newForm.setAttribute("id", "passeggero-".concat(num));


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

    newForm.appendChild(documento);


    let tipoBambinoDiv = document.createElement("input");
    tipoBambinoDiv.setAttribute("type", "text");
    tipoBambinoDiv.setAttribute("nome", "tipoBambino");
    tipoBambinoDiv.setAttribute("readonly", true);
    
    if (tipoBambino != "bambino") {
        tipoBambino = "adulto";
    }
    tipoBambinoDiv.setAttribute("value", tipoBambino);

    newForm.appendChild(tipoBambinoDiv);


    let prenotazioneInput = document.createElement("input");
    prenotazioneInput.setAttribute("type", "number");
    prenotazioneInput.setAttribute("nome", "numeroPrenotazione");
    prenotazioneInput.setAttribute("readonly", true);
    prenotazioneInput.hidden = true;
    const numPrenotazione = document.getElementById("totalRequested").innerHTML;
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
    let tot = document.getElementById('totalRequested').innerHTML;
    console.log(tot);
    tot -= document.getElementById('checkedTickets').innerHTML;
    console.log(tot);
    if (tot < 0) {
        alert("An unexpected error occurred");
    }
//>>>>>>>>>>>>>>>>>>>>>TO DO CHANGE THIS
    for(let i = 0; i < tot; i++ )
        insertPasseggero(i,"adulti");
}
