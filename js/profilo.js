function rowClick(idPrenotazione) {
    let newForm = document.createElement("form");
    newForm.setAttribute("action", "biglietti.php");
    newForm.setAttribute("method", "post");
    newForm.setAttribute("hidden", true);

    let inputElem = document.createElement("input");
    inputElem.setAttribute("type", "number");
    inputElem.setAttribute("name", "idPrenotazione")
    inputElem.setAttribute("value", idPrenotazione);
    inputElem.setAttribute("hidden", true);
    newForm.appendChild(inputElem);
    
    document.body.appendChild(newForm);

    newForm.submit();
}