<?php
  include("assets/php/console.php");
  include("assets/php/jsonClass.php");
  $database = new jsonClass("assets/json/database.json");
  $db = $database->getJsonArray();
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>WhitelineStyle Stammkunden</title>
    <link rel="stylesheet" href="assets/css/colors.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!--<script src="assets/json/database.json" charset="utf-8"></script>
    <script src="assets/js/script.js" charset="utf-8"></script>-->
  </head>
  <body>
    <h1>WhitelineStyle Stammkunden</h1>
    <h3 class="h3CustomHeader1">Suchen</h3>
    <form class="search" action="index.php" method="get">
      <input type="text" name="search_input" Placeholder="Name, Artikel, Preis">
      <input type="submit" value="Suchen">
    </form>
    <h3 class="h3CustomHeader1">Hinzufügen</h3>
    <form class="hinzufuegen" action="hinzufuegen.php" method="get">
      <input type="text" name="personName" placeholder="Name">
      <input type="text" name="artikelName" placeholder="Artikelname">
      <input type="number" name="anzahl" placeholder="Anzahl" min=0>
      <input type="number" name="preis" placeholder="Preis" min=0.01 step=0.01><span class="input_number_symbol">€</span>
      <input type="submit" value="Hinzufügen">
    </form>
    <h3 class="h3CustomHeader1">Sortieren</h3>
    <div class="linkCollection">
      <a href="index.php?sort=all">Alle</a>
      <a href="index.php?sort=open">Offen</a>
      <a href="index.php?sort=closed">Geschlossen</a>
    <div>
      <table>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Artikelname</th>
          <th>Anzahl</th>
          <th>Preis</th>
          <th>Erledigt</th>
          <th>Bearbeiten</th>
        </tr>
        <?php
        console::log($db);
        //Zuerst überprüfe ich, ob ein Suchkriterium gegeben ist.
        $SearchValues = [];
        if(isset($_GET["search_input"])){
          $SearchValues = explode(" ", str_replace("+", " ", $_GET["search_input"]));
          console::log($SearchValues);
        }

        foreach($db as $key => $value){
          $erledigt = "";
          if((isset($_GET["sort"]) and $_GET["sort"] == "all") || (!isset($_GET["sort"]) && !isset($_GET["search_input"]))){
            ObjectHinzufuegen($value);
          } else if((isset($_GET["sort"]) and $_GET["sort"] == "closed") && $value["erledigt"]){
            ObjectHinzufuegen($value);
          } else if((isset($_GET["sort"]) and $_GET["sort"] == "open") && !$value["erledigt"]){
            ObjectHinzufuegen($value);
          } else if(isset($_GET["search_input"])){
            $inside = [];
            foreach ($SearchValues as $key => $SValue) {
              console::log(str_contains(strtolower(strval($value["name"])), strtolower($SValue)));
              if((str_contains(strtolower(strval($value["id"])), strtolower($SValue)) || str_contains(strtolower(strval($value["name"])), strtolower($SValue)) || str_contains(strtolower(strval($value["artikelName"])), strtolower($SValue)) || str_contains(strtolower(strval($value["anzahl"])), strtolower($SValue)) || str_contains(strtolower(strval($value["preis"])), strtolower($SValue))) && !in_array($value["id"], $inside)){
                array_push($inside, $value["id"]);
                ObjectHinzufuegen($value);
              }
            }
          }
        }

        function ObjectHinzufuegen($value){
          $erledigt = $value["erledigt"] ? "Geschlossen" : "Offen";
          echo "
          <tr>
            <td>{$value["id"]}</td>
            <td>{$value["name"]}</td>
            <td>{$value["artikelName"]}</td>
            <td>{$value["anzahl"]}</td>
            <td>{$value["preis"]}</td>
            <td>{$erledigt}</td>
            <td><a href='edit.php?id={$value["id"]}' class='edButton_{$value["id"]}'>Bearbeiten</a></td>
          </tr>
          ";
        }
        ?>
      </table>
  </body>
</html>
