<?php
include("../Fonctions/Fonctions.php");
$sumbit=$_POST['button2'];
$nom=$_POST['NDB'];
$AddDB = new GererDB();
if(isset($sumbit)){
    $AddDB->AddDB($nom);
    header('location: ./DBGestion.php');
}

?>