window.onload = () => {
console.log("JS loaded...");
class Object{
  constructor(id, name, artikelname, anzahl, preis, erledigt){
    this.id = id;
    this.name = name;
    this.artikelname = artikelname;
    this.anzahl = anzahl;
    this.preis = preis;
    this.erledigt = erledigt;
  }

  getId(){ return this.id; }
  setId(id){ this.id = id; }

  getName(){ return this.name; }
  setName(name){ this.name = name; }

  getArtikelname(){ return this.artikelname; }
  setArtikelname(artikelname){ this.artikelname = artikelname; }

  getAnzahl(){ return this.anzahl; }
  setAnzahl(anzahl){ this.anzahl = anzahl; }

  getPreis(){ return this.preis; }
  setPreis(preis){ this.preis = preis; }

  getErledigt(){ return this.erledigt; }
  setErledigt(erledigt){ this.erledigt = erledigt; }
}

var TabellenWerte = [
  new Object(0, "Benjamin Battenfeld", "T-Shirt 160A BlauGrün M", 1, 50, false),
  new Object(1, "Luna Lovegood", "Hose 15B Blau S", 1, 23.99, true),
  new Object(2, "Emma Watson", "Bluse 3A Schwarz S", 1, 19.99, false),
  new Object(3, "Dario Hagemann", "Slips weiß XXL", 55, 16.75, false)
];

//Damit neue Werte oben angezeigt werden muss ich das Array einmal drehen
TabellenWerte = TabellenWerte.sort().reverse();

//Mit dieser Zeile erstelle ich eine Suchabfrage um die Werte zu filtern.
//Die Werte die innerhalb der If-Abfrage eingefügt werden, müssen der Reihenfolge entsprechen wie sie unten in dem
// head [Array] festgelegt sind, ansonsten werden diese in der falschen Reihenfolge angezeigt.

//Zuerst überprüfe ich, ob ein Suchkriterium gegeben ist.
SearchValues = [];
if(findGetParameter("search_input")){
  var SearchValues = findGetParameter("search_input").split(" ");
}

//Hier erstelle ich für jeden Wert eine eigene Zeile mit den zugehörigen Werten.
var Objects = [];
TabellenWerte.forEach(function(Object){
  var editButton = document.createElement('a');
  editButton.classList.add('edButton_'+Object.getId());
  editButton.innerHTML = "Bearbeiten";
  editButton.href = "edit.html?edit="+Object.getId();

  if(findGetParameter("sort") == "all" || (!findGetParameter("sort") && !findGetParameter("search_input"))){
    var erledigt = "";
    if(Object.getErledigt())
      erledigt = "Geschlossen";
    else
      erledigt = "Offen";
    Objects.push([Object.getId(), Object.getName(), Object.getArtikelname(), Object.getAnzahl(), Object.getPreis().toFixed(2)+" €", erledigt, editButton]);
  } else if((findGetParameter("sort") == "closed") && (Object.getErledigt())){
    Objects.push([Object.getId(), Object.getName(), Object.getArtikelname(), Object.getAnzahl(), Object.getPreis().toFixed(2)+" €", "Geschlossen", editButton]);
  } else if((findGetParameter("sort") == "open") && !Object.getErledigt()){
    Objects.push([Object.getId(), Object.getName(), Object.getArtikelname(), Object.getAnzahl(), Object.getPreis().toFixed(2)+" €", "Offen", editButton]);
  } else if(findGetParameter("search_input")){
    var inside = [];
    SearchValues.forEach(function(Value){
      if((Object.getId().toString().includes(Value) || Object.getName().includes(Value) || Object.getArtikelname().includes(Value) || Object.getAnzahl().toString().includes(Value) || Object.getPreis().toString().includes(Value)) && !inside.includes(Object.getId())){
        inside.push(Object.getId());
        var erledigt = "";
        if(Object.getErledigt())
        erledigt = "Geschlossen";
        else
        erledigt = "Offen";
        Objects.push([Object.getId(), Object.getName(), Object.getArtikelname(), Object.getAnzahl(), Object.getPreis().toFixed(2)+" €", erledigt, editButton]);
      }
    });
  }
});

createTable(Objects);

function createTable(tableData) {
  //Mit dieser Funktion ersetelle ich die Tabelle in der die Werte eingetragen werden.
  var table = document.createElement('table');
  var tableBody = document.createElement('tbody');

  //An dieser Stelle erstelle ich den die Kopf-Zeile der Tabelle
  var header = document.createElement('tr');
  //Da der Aufbau der Tabelle im späteren Verlauf nicht bearbeitet wird kann ich hier eine Fixe Poition festlegen, wie die Tabelle Aufgebaut sein wird.
  var head = ["Id", "Name", "Produktname", "Anzahl", "Preis", "Erledigt", "Bearbeiten"];
  for(var i=0; i<head.length; i++){
    var cell = document.createElement('th');
    cell.appendChild(document.createTextNode(head[i]));
    header.appendChild(cell);
    tableBody.appendChild(header);
  }

  //An dieser Stelle füge ich die oben festgelegten Werte in die Tabelle ein
  tableData.forEach(function(rowData) {
    var row = document.createElement('tr');
    rowData.forEach(function(cellData) {
      var cell = document.createElement('td');
      //Ich überprüfe ob der Inhalt ein Object (also zum Beispiel ein Button) ist, wenn dies der Fall ist will ich dass
      // ein Button erstellt wird, wenn nicht dann will ich, dass der Inhalt als Text ausgegeben wird.
      if(typeof cellData === 'object' && cellData !== null)
        cell.appendChild(document.body.appendChild(cellData))
      else
        cell.appendChild(document.createTextNode(cellData));
      row.appendChild(cell);
    });
    tableBody.appendChild(row);
  });

  //Hier übernimmt die Tabelle dann den einzufügenden Inhalt
  table.appendChild(tableBody);
  //Und hier erstellt das Script die Tabelle als entgültige Tabelle und gibt diese aus.
  document.body.appendChild(table);
}

//Mit dieser Funtion kann ich Parameter aus der URL-Liste auslesen und die Werte zurückgeben
function findGetParameter(parameterName) {
    var result = null;
    var tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName)
          return decodeURIComponent(tmp[1]).replace("+", " ");
    }
    return false;
}
/**/
}
