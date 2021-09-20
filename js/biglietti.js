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
    tipoBambinoDiv.setAttribute("id", "tipoPasseggero-".concat(num));

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

    let formBagagli = document.createElement("form");
    formBagagli.setAttribute("method", "post");
    formBagagli.setAttribute("id", "bagaglio-".concat(num));
    formBagagli.setAttribute("action", "./extraPay.php");


    let bagagli = document.createElement("input");
    bagagli.setAttribute("type", "number");
    bagagli.setAttribute("name", "bagagli");
    bagagli.setAttribute("value", "1");
    bagagli.setAttribute("min", "1");
    bagagli.setAttribute("max", '10');

    formBagagli.appendChild(bagagli);


    let aggiungiBagagli = document.createElement("input");
    aggiungiBagagli.setAttribute("type", "submit");
    aggiungiBagagli.setAttribute("value", "Aggiungi");

    formBagagli.appendChild(aggiungiBagagli);



    document.body.appendChild(newForm);
    document.body.appendChild(formBagagli);
} 


function firstLoadPasseggeri() {
    let adultsNum = parseInt(document.getElementById('adultRequested').value);
    let childrenNum = parseInt(document.getElementById('childrenRequested').value);
    adultsNum -= parseInt(document.getElementById('checkedAdults').value);
    childrenNum -= parseInt(document.getElementById('checkedChildren').value);
    
    if (adultsNum < 0 || childrenNum < 0) {
        alert("An unexpected error occurred");
        console.log("adults or children tickets are less than their kind of checked tickets o_O .");
    }
//>>>>>>>>>>>>>>>>>>>>>TO DO: rincontrollare
    for(let i = 0; i < adultsNum; i++ )
        insertPasseggero(i, "adulto");

    const tot = childrenNum + adultsNum;
    for (let i = adultsNum; i < tot; i++)
        insertPasseggero(i, "bambino");
}
