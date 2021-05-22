<?php
include("console.php");
include("jsonClass.php");
$database = new jsonClass("../json/database.json");
$dbJson = $database->getJsonArray();

if(isset($_GET["id"]))
  $searchedId = $_GET["id"];
else
  echo "<script>window.location = '../../index.php'></script>";

if(isset($_GET["method"]) and $_GET["method"] == "einfuegen"){
  $id = $_POST["id"];
  $name = $_POST["personName"];
  $beschreibung = $_POST["beschreibung"];
  $anzahl = $_POST["anzahl"];
  $preis = $_POST["preis"];
  $erledigt = isset($_POST["erledigt"]) ? true : false;
  $beschreibung = str_replace("\r\n", "<br/>", $beschreibung);
  $array = ["id"=>$id, "name"=>$name, "beschreibung"=>$beschreibung, "anzahl"=>$anzahl, "preis"=>$preis, "erledigt"=>$erledigt];
  $dbJson[$id] = $array;
  /**/
  if($database->setJsonArray($dbJson)){
    echo "<script>window.location = '../../index.php?msg=success';</script>";
  } else {
    echo "<script>window.location = '../../index.php?msg=fail';</script>";
  }
  /**/

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/colors.css<?php echo "?".date("dmYHis"); ?>">
    <link rel="stylesheet" href="../css/fonts.css<?php echo "?".date("dmYHis"); ?>">
    <link rel="stylesheet" href="../css/style_edit.css<?php echo "?".date("dmYHis"); ?>">
  </head>
  <body>
    <h3>Bearbeiten</h3>
    <form class="bearbeiten_form" action="edit.php?method=einfuegen" method="post">
      Id: <br/>
      <input type="text" name="id" value="<?php echo $searchedId; ?>" readonly data-header="id" style="color:#777">
      <br/>
      Name:<br/>
      <input type="text" name="personName" value="<?php echo $dbJson[$searchedId]["name"]; ?>" data-header="Name">
      <br/>
      Beschreibung:<br/>
      <textarea class="input_text" name="beschreibung" data-header="Beschreibung"><?php echo str_replace("<br/>", "\r\n", $dbJson[$searchedId]["beschreibung"]); ?></textarea>
      <br/>
      Anzahl:<br/>
      <input type="number" name="anzahl" value="<?php echo $dbJson[$searchedId]["anzahl"]; ?>" min=0 data-header="Anzahl">
      <br/>
      Preis:<br/>
      <input type="number" name="preis" value="<?php echo $dbJson[$searchedId]["preis"]; ?>" min=0 step=0.01 data-header="Preis">
      <br/>
      <input type="checkbox" name="erledigt" <?php echo (isset($dbJson[$searchedId]["erledigt"]) and $dbJson[$searchedId]["erledigt"]) ? "checked" : ""; ?>> Erledigt
      <br/>
      <input type="submit" value="Ändern">
    </form>
  </body>
</html>
