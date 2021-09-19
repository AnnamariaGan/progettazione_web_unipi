//index.php
//data minima possibile per i datapicker
let today = new Date();
var day = today.getDate();
var month = today.getMonth() + 1; // GENNAIO è 0
var year = today.getFullYear();
if (day < 10) {
    day = '0' + day;
}
if (month < 10) {
    month = '0' + month;
}
today = year + '-' + month + '-' + day;
document.getElementById("data_partenza").setAttribute("min", today); //cerca_volo = nome.form
document.getElementById("data_ritorno").setAttribute("min", today);

function onChangeRitorno(){
    let ritorno = document.getElementById("data_ritorno").value;
    
    if(ritorno){
        document.getElementById("data_partenza").setAttribute("max", ritorno );
    }
}

function onChangePartenza(){
    let partenza = document.getElementById("data_partenza").value;
    
    if(partenza){
        document.getElementById("data_ritorno").setAttribute("min", partenza );
    }
}

function onChangeAndata(){ 
    //disabilito la data ritorno se andata è spuntato
    // e la riabilito altrimenti
    data_ritorno.disabled = document.getElementById("andata").checked;  
}


