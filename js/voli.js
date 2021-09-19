/*function rowClick(idVolo){
    // de evidenzia la UI in ogni caso
    clickRestore('andataDiv');
    rimuoviImporto('pA-', 'andataDiv');
    // se idVolo != andataDiv.value aggiungi il costo
    if (idVolo != document.getElementById('andataDiv').value) {
        document.getElementById('andataDiv').value = idVolo;
        feedbackClick('row-'.concat(idVolo));
        calcolaImporto('pA-'.concat(idVolo));
    } else {
        document.getElementById('andataDiv').value = '';
        document.getElementById('importoTotale').innerHTML = '';
    }

    prenotaUtility();
}

function rowClickAndata(idVolo){
    clickRestore('andataDiv');
    rimuoviImporto('pA-', 'andataDiv');
    if (idVolo != document.getElementById('andataDiv').value) {
        document.getElementById('andataDiv').value = idVolo;
        feedbackClick('row-'.concat(idVolo));
        calcolaImporto('pA-'.concat(idVolo));
    } else {
        document.getElementById('andataDiv').value = '';
        document.getElementById('importoTotale').innerHTML = '';
    }
    prenotaUtility();
}

function rowClickRitorno(idVolo){
    clickRestore('ritornoDiv');
    rimuoviImporto('pR-', 'ritornoDiv');
    if (idVolo != document.getElementById('ritornoDiv').value) {
        document.getElementById('ritornoDiv').value = idVolo;
        feedbackClick('row-'.concat(idVolo));
        calcolaImporto('pR-'.concat(idVolo));
    } else {
        document.getElementById('ritornoDiv').value = '';
        document.getElementById('importoTotale').innerHTML = '';
    }
    prenotaUtility();
}

function feedbackClick(idRow) {
    document.getElementById(idRow).style = "background-color: rgba(245, 178, 178, 0.9); border: 3px solid rgba(0, 0, 0, 0.8);";
}

function clickRestore(idDiv) {
    let idVolo = document.getElementById(idDiv).value;
    if (idVolo == '') {
        return;
    }
    let idRow = 'row-'.concat(idVolo);
    document.getElementById(idRow).style = "background-color: rgba(255, 255, 255, 0.8); border: 1px solid rgba(0, 0, 0, 0.8);";
    
}

function rimuoviImporto(tipo, idDiv) {
    if (document.getElementById(idDiv).innerHTML == '') {
        return;
    }

    let idPrezzo = tipo.concat(document.getElementById(idDiv).value);
    let adulti = document.getElementById('numero-Adulti').innerHTML;
    adulti = (adulti == '') ? 0 : parseFloat(adulti);

    let bambini = document.getElementById('numero-Bambini').innerHTML;
    bambini = (bambini == '') ? 0 : parseFloat(bambini);

    let costo = document.getElementById(idPrezzo).innerHTML;
    costo = (costo == '') ? 0 : parseFloat(costo);
    
    //console.log(adulti,' ', bambini, " ", costo);
    let totale = parseFloat(costo)*(parseFloat(adulti)+0.5*parseFloat(bambini));

    let attuale = document.getElementById('importoTotale').innerHTML;
    attuale = (attuale == '') ? 0 : parseFloat(attuale);

    attuale -= totale;
    //console.log(attuale);
    document.getElementById('importoTotale').innerHTML = (attuale <= 0) ? '' : attuale;
}
*/

function calcolaImporto(idVolo, tipo, remove = false) {
    const idUtil = tipo == 'andataDiv' ? 'pA-' : 'pR-';
    const idPrezzo = idUtil.concat(idVolo);

    let adulti = document.getElementById('numero-Adulti').innerHTML;
    adulti = (adulti == '') ? 0 : parseFloat(adulti);

    let bambini = document.getElementById('numero-Bambini').innerHTML;
    bambini = (bambini == '') ? 0 : parseFloat(bambini);

    let costo = document.getElementById(idPrezzo).innerHTML;
    costo = (costo == '') ? 0 : parseFloat(costo);
    
    //console.log(adulti,' ', bambini, " ", costo);

    let totale = parseFloat(costo)*(parseFloat(adulti)+0.5*parseFloat(bambini));

    let attuale = document.getElementById('importoTotale').innerHTML;
    attuale = (attuale == '') ? 0 : parseFloat(attuale);

    if (remove) {
        totale = attuale - totale;
    } else {
        totale += attuale;
    }

    document.getElementById('importoTotale').innerHTML = totale;
}

function prenotaUtility() {
    const andataDiv = document.getElementsByName("andataDiv").length;
    const ritornoDiv = document.getElementsByName("ritornoDiv").length;
    
    document.getElementById("button").disabled = (andataDiv == 0 && ritornoDiv == 0);  
}

function rowClickUtility(idVolo, tipo) {
    let form = document.getElementById("prenotaForm");
    let ids = document.getElementsByName(tipo);
    let idItem = (Array.from(ids)).find(id => id.value == idVolo);

    if (idItem === undefined) {
        let newItem = document.createElement("input");
        //newItem.id = tipo;
        newItem.type = "hidden";
        newItem.name = tipo;
        newItem.value = idVolo;

        form.appendChild(newItem);
        addSelection(idVolo);
        calcolaImporto(idVolo, tipo); 
    } else {
        idItem.remove(idItem);
        removeSelection(idVolo);
        calcolaImporto(idVolo, tipo, true);
    }

    prenotaUtility();
}

function addSelection(idVolo) {
    let idRow = 'row-'.concat(idVolo);
    document.getElementById(idRow).style = "background-color: rgba(245, 178, 178, 0.9); border: 3px solid rgba(0, 0, 0, 0.8);";
}

function removeSelection(idVolo) {
    let idRow = 'row-'.concat(idVolo);
    document.getElementById(idRow).style = "background-color: rgba(255, 255, 255, 0.8); border: 1px solid rgba(0, 0, 0, 0.8);";
}

function rowClick(idVolo){
    rowClickAndata(idVolo);
}
function rowClickAndata(idVolo){
    rowClickUtility(idVolo, 'andataDiv');
}

function rowClickRitorno(idVolo){
    rowClickUtility(idVolo, 'ritornoDiv');
}
