<?php
  include("assets/php/console.php");
  include("assets/php/jsonClass.php");
  $database = new jsonClass("assets/json/database.json");
  $db = $database->getJsonArray();
  if(!isset($_GET["search_input"]))
    $db = array_reverse($db);
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>WhitelineStyle Stammkunden</title>
    <link rel="stylesheet" href="assets/css/colors.css<?php echo "?".date("dmYHis"); ?>">
    <link rel="stylesheet" href="assets/css/fonts.css<?php echo "?".date("dmYHis"); ?>">
    <link rel="stylesheet" href="assets/css/style.css<?php echo "?".date("dmYHis"); ?>">
    <script src="assets/js/msgScript.js" charset="utf-8"></script>
    <!--<script src="assets/json/database.json" charset="utf-8"></script>
    <script src="assets/js/script.js" charset="utf-8"></script>-->
  </head>
  <body>
    <div class="content">
    <?php
     echo (isset($_GET["msg"]) && $_GET["msg"] == "success") ? "<div class='msg success'>Erfolgreich eingetragen.</div>" : "";
     echo (isset($_GET["msg"]) && $_GET["msg"] == "fail") ? "<div class='msg fail'>Konnte nicht eingetragen werden.</div>" : "";
    ?>
    <h1>WhitelineStyle Stammkunden</h1>
    <h3 class="h3CustomHeader1">Suchen</h3>
    <form class="search" action="index.php" method="get">
      <input type="text" name="search_input" Placeholder="Name, Artikel, Preis, ...">
      <input type="submit" value="Suchen">
    </form>
    <h3 class="h3CustomHeader1">Hinzufügen</h3>
    <form class="hinzufuegen" action="assets/php/add.php" method="post">
      <input type="text" name="personName" placeholder="Name">
      <textarea name="beschreibung" placeholder="Beschreibung" class="input_text"></textarea>
      <input type="number" name="anzahl" placeholder="Anzahl" min=0>
      <input type="number" name="preis" placeholder="Preis" min=0 step=0.01><span class="input_number_symbol">€</span>
      <input type="submit" value="Hinzufügen">
    </form>
    <h3 class="h3CustomHeader1">Sortieren</h3>
    <div class="linkCollection">
      <a href="index.php?sort=all">Alle</a>
      <a href="index.php?sort=open">Offen</a>
      <a href="index.php?sort=closed">Geschlossen</a>
    </div>
    <?php
      echo isset($_GET["search_input"]) ? "<h4>Alle Such-Ergebnisse für: \"".str_replace("+", " ", $_GET["search_input"])."\"</h4>" : "";
      ?>
      <table cellpadding="0" cellspacing="0">
        <tr>
          <th>Id</th>
          <th>Datum</th>
          <th>Name</th>
          <th class="length300">Beschreibung</th>
          <th>Anzahl</th>
          <th>Preis €</th>
          <th>Erledigt</th>
          <th>Bearbeiten</th>
          <th>Schließen</th>
          <th>Zuletzt geändert</th>
        </tr>
        <?php
        console::log($db);
        //Zuerst überprüfe ich, ob ein Suchkriterium gegeben ist.
        $SearchValues = [];
        if(isset($_GET["search_input"])){
          $SearchValues = explode(" ", str_replace("+", " ", $_GET["search_input"]));
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
              if((str_contains(strtolower(strval($value["id"])), strtolower($SValue)) || str_contains(strtolower(strval($value["name"])), strtolower($SValue)) || str_contains(strtolower(strval($value["beschreibung"])), strtolower($SValue)) || str_contains(strtolower(strval($value["anzahl"])), strtolower($SValue)) || str_contains(strtolower(strval($value["preis"])), strtolower($SValue))) && !in_array($value["id"], $inside)){
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
            <td>{$value["erstellt"]}</td>
            <td>{$value["name"]}</td>
            <td class='length300'>{$value["beschreibung"]}</td>
            <td>{$value["anzahl"]}</td>
            <td>{$value["preis"]}</td>
            <td ";
            if($value["erledigt"])
              echo "style='color:var(--success_dark)'";
            else
              echo "style='color:var(--danger)'";
            echo ">{$erledigt}</td>
            <td><a href='assets/php/edit.php?id={$value["id"]}' class='edButton_{$value["id"]}'>Bearbeiten</a></td>
            ";
            if(!$value["erledigt"])
              echo "<td><a href='assets/php/close.php?id={$value["id"]}&key=THISISKKEY' class='closeButton_{$value["id"]}'>Schließen</a></td>";
            else
              echo "<td><a class='closeButton_{$value["id"]} linkDisabled'>Schließen</a></td>";
            echo "
            <td>{$value["lastChange"]}</td>
          </tr>
          ";
        }
        ?>
      </table>
    </div>
  </body>
</html>
