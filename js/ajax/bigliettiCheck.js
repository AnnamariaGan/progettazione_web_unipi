function loadDoc(prenotazione) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("ticketList").innerHTML = this.responseText;
      }
    };

    xhttp.open("POST", "checkindbutil.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("prenotazione=".concat(prenotazione));
}
