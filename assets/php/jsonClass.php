<?php
//Hier wird eine Klasse names "jsonClass" erstellt, diese wird dazu genutzt um mit JSON-Dateien zu arbeiten.
class jsonClass{
  //String "jsonFileLink" erstellen, damit das entsprechende jsonClass-Object welches erstellt wird
  # den Pfad zur JSON-Datei beinhaltet, sodass man diesen wieder abrufen kann und für weitere Funktionen
  # verwenden kann.
  private $jsonFileLink = null; // $jsonFileLink => [String]

  //Beim erstellen eines "jsonClass"-Objektes wird der Link zur JSON-Datei gefordert, dieser wird dann direkt
  # beim erstellen des Objektes in den String "jsonFileLink" eingefügt.
  public function __construct($jsonFileLink){ //$jsonFileLink => [String]
    $this->jsonFileLink = $jsonFileLink;
  }

  //Mithilfe der "getJsonFileLink"-Funktion kann man den String "jsonFileLink" abfrufen,
  # den man dem Objekt beim Festlegen mitgegeben hat.
  public function getJsonFileLink(){ return $this->jsonFileLink; } // return [String]

  //Mithilfe der "getJsonArray"-Funktion kann man ein Array des aktuellen JSON-Dokuments,
  # welches man mit dem "jsonFileLink"-String (welches der Pfad zur JSON-Datei ist), ausgeben lassen.
  public function getJsonArray(){
    return json_decode(file_get_contents($this->jsonFileLink), true); //return [Array]
  }

  //Mithilfe der "setJsonArray"-Funktion kann man das JSON-Dokument bzw. den Inhalt, welches über den Pfad in
  # dem "jsonFileLink"-String festgelegt ist, bearbeiten. Dazu wird das entsprechende JSON-Array benötigt.
  # Die Daten aus dem mitgegebenen Array werden dann in der JSON-Datei gespeichert.
  public function setJsonArray($jsonArray){ //$jsonArray => [Array]
    //Wenn das bearbeiten der JSON-Datei erfolgreich gewesen ist gibt die Funtion "true" [boolean] zurück,
    # ansonsten gibt sie "false" [boolean] zurück.
    return file_put_contents($this->jsonFileLink, json_encode($jsonArray)) ? true : false; //return [boolean]
  }

}



?>
