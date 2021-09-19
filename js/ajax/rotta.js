let rotteMap = new Map();  //costruttore Map

//popolo la map
rotteMap.set("Alghero",["Bologna","Bari", "Catania", "Milano Malpensa", "Napoli", 
    "Palermo", "Pisa", "Pescara", "Venzia"]);

rotteMap.set("Brindisi",["Bologna","Cagliari","Roma Fiumicino","Milano Malpensa",
    "Palermo","Pisa","Torino","Venezia"]);

rotteMap.set("Milano Bergamo",["Alghero","Bologna","Cagliari","Roma Ciampino",
    "Catania","Roma Fiumicino","Palermo"]);

rotteMap.set("Bologna",["Alghero","Brindisi","Bari","Crotone","Catania","Palermo",
    "Lamezia Terme","Trapani"]);

rotteMap.set("Bari",["Alghero","Bologna","Cagliari","Catania","Cuneo",
    "Roma Fiumicino","Genova","Milano Linate","Palermo","Pisa","Torino",
    "Venezia","Verona"]);

rotteMap.set("Cagliari",["Brindisi","Bologna","Bari","Catania","Roma Fiumicino",
    "Milano Linate","Parma","Palermo","Pisa","Trieste"]);

rotteMap.set("Roma Ciampino",["Cagliari","Trapani"]);

rotteMap.set("Crotone",["Bologna","Milano Malpensa"]);

rotteMap.set("Catania",["Alghero","Bologna","Bari","Roma Ciampino","Milano Malpensa",
    "Napoli","Pisa","Torino"]);

rotteMap.set("Roma Fiumicino",["Brindisi","Bari","Catania","Palermo"]);

rotteMap.set("Milano Malpensa",["Alghero","Bari","Cagliari","Catania","Palermo",
    "Lamezia Terme","Trapani"]);

rotteMap.set("Perugia",["Catania","Palermo","Lamezia Terme"]);

rotteMap.set("Palermo",["Brindisi","Bologna","Bari","Roma Ciampino","Milano Linate"
    ,"Napoli","Pisa","Torino","Venezia","Verona"]);

rotteMap.set("Pisa",["Alghero","Brindisi","Bari","Cagliari","Catania","Palermo",
    "Lamezia Terme","Trapani"]);

rotteMap.set("Pescara",["Cagliari","Catania","Milano Linate","Trapani","Torino"]);

rotteMap.set("Lamezia Terme",["Bologna","Milano Linate","Pisa","Trapani","Torino"]); 

rotteMap.set("Trapani",["Bergamo","Bologna","Roma Ciampino","Pisa","Pescara",
    "Lamezia Terme","Venezia"]); 

rotteMap.set("Treviso",["Alghero","Cagliari","Lamezia Terme","Trapani"]); 

let partenze = Array.from(rotteMap.keys());

let list = document.getElementById('partenze');

partenze.forEach(function(item){
	let option = document.createElement('option');
	option.value = item;
	list.appendChild(option);
});

function reloadDestinazioni() {
    let destinazioniList = document.getElementById('destinazioni');
    const partenza = document.getElementById('partenza').value;
    
    while(destinazioniList.firstChild) {    
        destinazioniList.firstChild.remove();
    }

    try {
        rotteMap.get(partenza).forEach(function(item){
            let option = document.createElement('option');
            option.value = item;
            destinazioniList.appendChild(option);
        });
    } catch(error) {
        //Do nothing, expected behaviour
    }
    
}