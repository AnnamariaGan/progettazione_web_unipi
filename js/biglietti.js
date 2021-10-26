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
    
    let nomeLabel = document.createElement("label");
    nomeLabel.innerHTML = "nome";
    newForm.appendChild(nomeLabel);
    newForm.appendChild(nome);


    let cognome = document.createElement("input");
    cognome.setAttribute("type", "text");
    cognome.setAttribute("name", "Cognome");
    cognome.setAttribute("value", "");

    let cognomeLabel = document.createElement("label");
    cognomeLabel.innerHTML = "cognome";
    newForm.appendChild(cognomeLabel);
    newForm.appendChild(cognome);
  

    let documento = document.createElement("input");
    documento.setAttribute("type", "text");
    documento.setAttribute("name", "Documento");
    documento.setAttribute("value", "");
    documento.setAttribute("pattern", "[A-Za-z0-9]{9}")

    let documentoLabel = document.createElement("label");
    documentoLabel.innerHTML = "documento";
    newForm.appendChild(documentoLabel);
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


    document.body.appendChild(newForm);
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

function formatRenspose(arrayTexts) {
    try {
        const nome = arrayTexts[0];
        const cognome = arrayTexts[1];
        const documento = arrayTexts[2];
        const id = arrayTexts[3];
        const ageClass = arrayTexts[4];
    
        // Crea la grid row
        const gridrow = document.createElement("div");
        gridrow.className = "grid-row";

        function addItemUtil(tipo, gridrow) {
            // crea grid cell
            const item = document.createElement("div");
            item.className = "grid-item";
            // aggiungi contenuto cella
            item.appendChild(document.createTextNode(tipo));
            // aggiungi item alla row
            gridrow.appendChild(item);
        }

        addItemUtil(nome+" "+cognome, gridrow);
        addItemUtil(documento, gridrow);
        addItemUtil(id+"\n"+ageClass, gridrow);

        return gridrow;
        
        /*
                echo '<div class="grid-item">';
                    echo $nome.' '.$cognome;
                echo '</div>';

                echo '<div class="grid-item">';
                    echo $documento;
                echo '</div>';
            
                echo '<div class="grid-item">';
                    echo md5($idPrenotazione);
                    if ($bambino == 1) {
                        echo '<br> bambino';
                    } else {
                        echo '<br> adulto';
                    }
                echo '</div>';
            
            echo '</div>';
        */
    } catch (error) {
        console.error("Sembra che ci siano dati mancanti effettuando il check-in!");
    }
}


