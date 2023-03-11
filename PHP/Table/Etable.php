<?php
include("../Fonctions/Fonctions.php");
$sumbit=$_POST['button2'];
$db = $_POST['db'];
$old_table = $_POST['old'];
$new_table=$_POST['New_table'];



if(isset($sumbit)){
    $edit = new GererTable();
    $edit->EditNameTable($db,$old_table,$new_table);
    header('Location: ./column.php?Name_Table='.$new_table.'&Nom_db='.$db);
}

?>