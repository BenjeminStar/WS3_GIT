<?php
$key = "THISISKKEY";
if(isset($_GET["key"]) and $_GET["key"] == $key){
  include("console.php");
  include("jsonClass.php");
  $database = new jsonClass("../json/database.json");
  $dbJson = $database->getJsonArray();

  $searchedId = $_GET["id"];
  $dbJson[$searchedId]["erledigt"] = true;
  if($database->setJsonArray($dbJson)){
    echo "<script>window.location = '../../index.php?msg=success';</script>";
  } else {
    echo "<script>window.location = '../../index.php?msg=fail';</script>";
  }
}
?>
