<?php
include("jsonClass.php");
$database = new jsonClass("../json/database.json");
$dbJson = $database->getJsonArray();

//Die neue ID ist gleich die ID+1 des zuletzt eingefügten Objects.
$id = count($dbJson);
foreach ($dbJson as $key => $value) {
  if($value["id"] == $id)
    $id++;
}

//Werte aus POST auslesen

$name = isset($_POST["personName"]) ? $_POST["personName"] : "Unbekannt";
$beschreibung = isset($_POST["beschreibung"]) ? htmlspecialchars($_POST["beschreibung"]) : "Keine Beschreibung vorhanden.";
$anzahl = isset($_POST["anzahl"]) ? $_POST["anzahl"] : 1;
$preis = isset($_POST["preis"]) ? $_POST["preis"] : 0;
$erledigt = false;
$created = date("d.m.Y");
$date = date("d.m.Y H:i:s");
//Ausgelesene Werte in das Array eintragen und in der Datenbank speichern
$neuerEintrag = ["id"=>$id, "erstellt"=>$created,"name"=>$name, "beschreibung"=>$beschreibung, "anzahl"=>$anzahl, "preis"=>$preis, "erledigt"=>$erledigt, "lastChange"=>$date];
array_push($dbJson, $neuerEintrag);

if($database->setJsonArray($dbJson)){
  echo "<body style='background:var(--success);'></body>";
  echo "<script>window.location = '../../index.php?msg=success';</script>";
} else {
  echo "<body style='background:var(--danger);'></body>";
  echo "
    <script>window.location = '../../index.php?msg=fail';</script>
  ";
}
/**/

?>
