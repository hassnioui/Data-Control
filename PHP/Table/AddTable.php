<?php
include("../Fonctions/Fonctions.php");
$sumbit=$_POST['button2'];
$db= $_POST['db'];
$Ntable=$_POST['Ntable'];

if(isset($sumbit)){
    $add = new GererTable();
    $add->addTable($db,$Ntable);
    header('Location: ../Table/column.php?Name_Table='.$Ntable.'&Nom_db='.$db);
}

?>